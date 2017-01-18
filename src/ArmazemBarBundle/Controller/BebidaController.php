<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Controller;

use ArmazemBarBundle\Entity\Bebida;
use ArmazemBarBundle\Form\BebidaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of BebidaController
 * @Route("/bebida")
 * @author Luciano
 */
class BebidaController extends Controller
{
    
    /**
     * @Route("/", name="bebida_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $success = "";
        if ($request->getSession()->getFlashBag()->has("success")) {
            $success = $request->getSession()->getFlashBag()->get("success");
            $request->getSession()->getFlashBag()->clear();
        }
        
        return array('success' => $success);
    }
    
    /**
     * @Route("/pagination", name="bebida_pagination")
     * @return Response
     */
    public function paginationAction()
    {
        $bebidas = $this->getDoctrine()->getRepository(Bebida::class)->findAll();
        $dados = array();
        foreach ($bebidas as $bebida) {
            /* @var $bebida Bebida  */
            $btnStatus = $bebida->getAtivo() ? 
                    "<a title=\"Desativar\" class=\"btn btn-default btn-sm\" href=\"javascript:trocarStatus(".$bebida->getId() .", 0);\"><i class=\"fa fa-remove\"></i></a>"
                    : "<a title=\"Ativar\" class=\"btn btn-default btn-sm\" href=\"javascript:trocarStatus(".$bebida->getId() .", 1);\"><i class=\"fa fa-check\"></i></a>";
            $dados[] = [
                "<a title=\"Editar\" href=\"".$this->generateUrl("bebida_form", array("id"=>$bebida->getId())) ."\"><span class=\"h4\">". $bebida->getDescricao() ."</span></a>",
                "<h5>". $bebida->getQuantidadeEstoque() ."</h5>",
                $bebida->getAtivo() ? "<em class='fa fa-check'></em>" : "<em class='fa fa-remove'></em>",
                "<div class=\"btn-group\">".$btnStatus."<a title=\"Excluir\" class=\"btn btn-default btn-sm\" href=\"javascript:excluir(".$bebida->getId() .");\"><i class=\"glyphicon glyphicon-trash\"></i></a></div>",
            ];
        }
        $return['recordsTotal'] = count($bebidas);
        $return['recordsFiltered'] = count($bebidas);
        $return['data'] = $dados;
        return new Response(json_encode($return));
    }

    
    /**
     * 
     * @Route("/editar/{id}", name="bebida_form")
     * @Template()
     */
    public function formAction(Request $request, $id = 0) 
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id>0) {
            $bebida = $em->find(Bebida::class, $id);
        } else {
            $bebida = new Bebida();
        }
        
        $form = $this->createForm(BebidaType::class, $bebida);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($bebida);
            $em->flush();
            $msg = $id==0 ? "Bebida <strong>incluída</strong> com sucesso." : "Bebida <strong>alterada</strong> com sucesso.";
            $request->getSession()->getFlashBag()->add("success", $msg);
            return $this->redirectToRoute("bebida_index");
        }
        
        return array("bebida"=>$bebida, "form"=>$form->createView());
    }
    
    /**
     * @Route("/excluir", name="bebida_excluir")
     */
    public function excluiAction(Request $resquest) 
    {
        $response   = array('ok'=>0);
        $id         = $resquest->get("id");
        if (is_null($id)) {
            $response['error'] = "Erro ao excluir bebida, ID vazio!";
        } else {
            $em = $this->getDoctrine()->getManager();
            $bebida = $em->find(Bebida::class, $id);
            if (is_null($bebida)) {
                $response['error'] = "Erro ao excluir, bebida não encontrado!";
            } else {
                if ($bebida->getPedidoBebidas()->count()>0){
                    $response['error'] = "Não é possível excluir a bebida, existem Pedidos vinculados!";
                } else {
                    if ($bebida->getCompraBebidas()->count()>0){
                        $response['error'] = "Não é possível excluir a bebida, existem Compras vinculadas!";
                    } else {
                        try {
                            $em->remove($bebida);
                            $em->flush();
                            $response['ok'] = 1;
                            $response['success'] = "Bebida <strong>excluída</strong> com sucesso!";
                        } catch (Exception $exc) {
                            $response['error'] = "Erro ao excluir Bebida, problema com o banco de dados!";
                        }
                    }
                }
            }
        }
        $response['message'] = $this->renderView("ArmazemBarBundle::Messages/message.html.twig", $response);
        return new Response(json_encode($response));
    }

    
    /**
     * @Route("/alterarStatus", name="bebida_status")
     */
    public function statusAction(Request $resquest) 
    {
        $response   = array('ok'=>0);
        $id         = $resquest->get("id");
        $status     = $resquest->get("status");
        
        if (is_null($id) || is_null($status)){
            $response['error'] = "Erro ao Alterar Status da Bebida, Status ou ID não enviados!";
        } else {
            $strStatus = $status ? "Ativar" : "Desativar";
            $em = $this->getDoctrine()->getManager();
            $bebida = $em->find(Bebida::class, $id);
            if (is_null($bebida)) {
                $response['error'] = "Erro ao ".$strStatus.", bebida não encontrada!";
            } else {
                if ($status) {
                    $bebida->setAtivo(TRUE);
                } else {
                    $bebida->setAtivo(FALSE);
                }
                
                try {
                    $em->merge($bebida);
                    $em->flush();
                    $response['ok'] = 1;
                    $response['success'] = "O Status da Bebida foi alterado com sucesso.";
                } catch (Exception $exc) {
                    $response['error'] = "Erro ao ".$strStatus.", bebida, problema no banco de dados!";
                }
            }
        }
        $response['message'] = $this->renderView("ArmazemBarBundle::Messages/message.html.twig", $response);
        return new Response(json_encode($response));

    }
    
}
