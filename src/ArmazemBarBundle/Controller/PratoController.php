<?php

namespace ArmazemBarBundle\Controller;

use ArmazemBarBundle\Entity\Prato;
use ArmazemBarBundle\Form\PratoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/pagination", name="prato_pagination")
     * @return Response
     */
    public function paginationAction()
    {
        $pratos = $this->getDoctrine()->getRepository(Prato::class)->findAll();
        $dados = array();
        foreach ($pratos as $prato) {
            /* @var $prato Prato  */
            $btnStatus = $prato->getAtivo() ? 
                    "<a title=\"Desativar\" class=\"btn btn-default btn-sm\" href=\"javascript:trocarStatus(".$prato->getId() .", 0);\"><i class=\"fa fa-remove\"></i></a>"
                    : "<a title=\"Ativar\" class=\"btn btn-default btn-sm\" href=\"javascript:trocarStatus(".$prato->getId() .", 1);\"><i class=\"fa fa-check\"></i></a>";
            $dados[] = [
                "<a href=\"".$this->generateUrl("prato_form", array("id"=>$prato->getId())) ."\"><span class=\"h4\">". $prato->getDescricao() ."</span></a>",
                $prato->getAtivo() ? "<em class='fa fa-check'></em>" : "<em class='fa fa-remove'></em>",
                "<div class=\"btn-group\">".$btnStatus."<a title=\"Excluir\" class=\"btn btn-default btn-sm\" href=\"javascript:excluir(".$prato->getId() .");\"><i class=\"glyphicon glyphicon-trash\"></i></a></div>",
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
        $em = $this->getDoctrine()->getManager();
        
        if ($id>0) {
            $prato = $em->find(Prato::class, $id);
        } else {
            $prato = new Prato();
        }
        
        $form = $this->createForm(PratoType::class, $prato);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($prato);
            $em->flush();
            $msg = $id==0 ? "Prato <strong>incluído</strong>  com sucesso." : "Prato <strong>alterado</strong> com sucesso.";
            $request->getSession()->getFlashBag()->add("success", $msg);
            return $this->redirectToRoute("prato_index");
        }
        
        return array("prato"=>$prato, "form"=>$form->createView());
    }
    
    /**
     * @Route("/excluir", name="prato_excluir")
     */
    public function excluiAction(Request $resquest) 
    {
        $response   = array('ok'=>0);
        $id         = $resquest->get("id");
        if (is_null($id)) {
            $response['error'] = "Erro ao excluir prato, ID vazio!";
        } else {
            $em = $this->getDoctrine()->getManager();
            $prato = $em->find(Prato::class, $id);
            if (is_null($prato)) {
                $response['error'] = "Erro ao excluir, prato não encontrado!";
            } else {
                if ($prato->getPedidoPratos()->count()>0){
                    $response['error'] = "Não é possível excluir o prato, existem Pedidos vinculados!";
                } else {
                    try {
                        $em->remove($prato);
                        $em->flush();
                        $response['ok'] = 1;
                        $response['success'] = "Prato <strong>excluído</strong> com sucesso!";
                    } catch (Exception $exc) {
                        $response['error'] = "Erro ao excluir prato, problema com o banco de dados!";
                    }
                }
            }
        }
        $response['message'] = $this->renderView("ArmazemBarBundle::Messages/message.html.twig", $response);
        return new Response(json_encode($response));
    }
    
    /**
     * @Route("/alterarStatus", name="prato_status")
     */
    public function statusAction(Request $resquest) 
    {
        $response   = array('ok'=>0);
        $id         = $resquest->get("id");
        $status     = $resquest->get("status");
        
        if (is_null($id) || is_null($status)){
            $response['error'] = "Erro ao Alterar Status do prato, Status ou ID não enviado!";
        } else {
            $strStatus = $status ? "Ativar" : "Desativar";
            $em = $this->getDoctrine()->getManager();
            $prato = $em->find(Prato::class, $id);
            if (is_null($prato)) {
                $response['error'] = "Erro ao ".$strStatus.", prato não encontrado!";
            } else {
                if ($status) {
                    $prato->setAtivo(TRUE);
                } else {
                    $prato->setAtivo(FALSE);
                }
                
                try {
                    $em->merge($prato);
                    $em->flush();
                    $response['ok'] = 1;
                } catch (Exception $exc) {
                    $response['error'] = "Erro ao ".$strStatus.", prato não encontrado!";
                }
            }
        }
        $response['message'] = $this->renderView("ArmazemBarBundle::Messages/message.html.twig", $response);
        return new Response(json_encode($response));

    }

    
}
