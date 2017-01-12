<?php

namespace ArmazemBarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
    
    
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        $errorMsg = "";
        // get the login error if there is one
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->set(Security::AUTHENTICATION_ERROR, "");
        }
        
        if (is_object($error)) {
            $errorMsg = $this->get("translator")->trans($error->getMessage());
        }

        return array(
            'last_username' => $session->get(Security::LAST_USERNAME),
            'error'         => $errorMsg,
        );
    }

    
    /**
     * @Route("/sem/permissao", name="sem_permissao")
     * @Template()
     */
    public function semPermissaoAction()
    {
        return array();
    }

}
