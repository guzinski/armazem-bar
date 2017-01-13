<?php

namespace ArmazemBarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Description of PratoController
 * @Route("/prato")
 * @author Luciano
 */
class PratoController extends Controller
{
    
    /**
     * @Route("/", name="prato_index")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
    
    /**
     * @Route("/pagination", name="prato_pagination")
     * @return Response
     */
    public function paginationAction()
    {
        $pratos = $this->getDoctrine()->getRepository(\ArmazemBarBundle\Entity\Prato::class)->findAll();
        $dados = array();
        foreach ($pratos as $prato) {
            /* @var $prato \ArmazemBarBundle\Entity\Prato  */
            $dados[] = [
                "<a href=\"".$this->generateUrl("prato_form", array("id"=>$prato->getId())) ."\">". $prato->getDescricao() ."</a>",
                "<a href=\"javascript:excluir(".$prato->getId() .");\"><i class=\"glyphicon glyphicon-trash\"></a>",
            ];
        }
        $return['recordsTotal'] = count($pratos);
        $return['recordsFiltered'] = count($pratos);
        $return['data'] = $dados;
        return new Response(json_encode($return));
    }

        /**
     * 
     * @Route("/editar/{id}", name="prato_form")
     * @Template()
     */
    public function formAction(Request $request, $id = 0) 
    {
        return [];
    }
    
    /**
     * @Route("/excluir", name="prato_excluir")
     */
    public function excluiAction(Request $resquest) 
    {
        return [];
    }

    
}
