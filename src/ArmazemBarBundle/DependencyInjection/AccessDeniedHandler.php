<?php

namespace ArmazemBarBundle\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

/**
 * Description of AccessDeniedHandler
 *
 * @author Luciano
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    
    protected $_session;
    protected $_router;
    protected $_request;

    public function __construct(Session $session, Router $router)
    {
        $this->_session = $session;
        $this->_router = $router;
    }

    
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        if ($request->isXmlHttpRequest()) {
            $error = array();
            $error['ok'] = 0;
            $error['error'] = "Você não tem permissão para esta ação";
            $response = new Response(json_encode(array('status' => 'protected')));
            return $response;
        } else {
            return new RedirectResponse($this->_router->generate('sem_permissao'));
        }
    }

}
