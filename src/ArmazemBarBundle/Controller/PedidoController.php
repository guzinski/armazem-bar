<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Controller;

use ArmazemBarBundle\Entity\Pedido;
use ArmazemBarBundle\Entity\PedidoBebida;
use ArmazemBarBundle\Entity\PedidoProduto;
use ArmazemBarBundle\Form\PedidoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PedidoController
 * @Route("/pedido")
 */
class PedidoController extends Controller
{
    
    /**
     * 
     * @Route("/", name="pedido_index")
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
     * 
     * @Route("/pagination", name="pedido_pagination")
     * @return Response
     */
    public function paginationAction()
    {
        $pedidos = $this->getDoctrine()->getRepository(Pedido::class)->findBy(array(), array('dataCadastro' => 'DESC'));;
        $dados = [];
        foreach ($pedidos as $pedido) {
            $dados[] = $this->trataPedidos($pedido);
        }
        $return['recordsTotal'] = count($pedidos);
        $return['recordsFiltered'] = count($pedidos);
        $return['data'] = $dados;
        return new Response(json_encode($return));
    }
    
    /**
     * 
     * @Route("/cozinha", name="pedido_cozinha")
     * @Template()
     */
    public function cozinhaAction(Request $request)
    {
        $success = "";
        if ($request->getSession()->getFlashBag()->has("success")) {
            $success = $request->getSession()->getFlashBag()->get("success");
            $request->getSession()->getFlashBag()->clear();
        }
        
        return array('success' => $success);
    }
    
    /**
     * 
     * @Route("/caixa", name="pedido_caixa")
     * @Template()
     */
    public function caixaAction(Request $request)
    {
        $success = "";
        if ($request->getSession()->getFlashBag()->has("success")) {
            $success = $request->getSession()->getFlashBag()->get("success");
            $request->getSession()->getFlashBag()->clear();
        }
        
        return array('success' => $success);
    }

    
    /**
     * 
     * @Route("/cozinha/pagination", name="pedido_cozinha_pagination")
     * @return Response
     */
    public function cozinhaPaginationAction(Request $request)
    {
        $pedidos = $this->getDoctrine()->getRepository(Pedido::class)->getPedidosCozinha($request->get("concluídos"), $request->get("cancelados"));
        $dados = [];
        foreach ($pedidos as $pedido) {
            $dados[] = $this->trataPedidos($pedido);
        }
        $return['recordsTotal'] = count($pedidos);
        $return['recordsFiltered'] = count($pedidos);
        $return['data'] = $dados;
        return new Response(json_encode($return));
    }

    
    private function trataPedidos(Pedido $pedido)
    {
        $pedidoBebidas = [];
        foreach ($pedido->getPedidoBebidas() as $pedidoBebida) {
            /* @var $pedidoBebida PedidoBebida  */
            $pedidoBebidas[] = [
                'descricao'     => $pedidoBebida->getBebida()->getDescricao(),
                'quantidade'    => $pedidoBebida->getQuantidade(),
            ];
        }
        $pedidoProdutos = [];
        foreach ($pedido->getPedidoProdutos() as $pedidoProduto) {
            /* @var $pedidoProduto PedidoProduto  */
            $pedidoProdutos[] = [
                'descricao'     => $pedidoProduto->getProduto()->getDescricao(),
                'quantidade'    => $pedidoProduto->getQuantidade(),
                'observacoes'     => $pedidoProduto->getObservacoes(),
            ];
        }

        return [
            'numero'            => $pedido->getId(),
            'numeroHtml'        => "<h4>".$pedido->getId()."</h4>",
            'data_pedido'       => $pedido->getDataCadastro()->format("d/m/Y"),
            'pedido_bebidas'    => $pedidoBebidas,
            'pedido_produtos'   => $pedidoProdutos,
            'situacao'          => $pedido->getStringSituacao(),
            'situacaoHtml'      => $pedido->getHtmlSituacao(),
        ];            
    }
    
    /**
     * 
     * @Route("/novo", name="pedido_novo")
     * @Template()
     */
    public function formAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();
        
        $pedido = new Pedido();
        $form = $this->createForm(PedidoType::class, $pedido);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($pedido);
            $em->flush();
            $msg = "Pedido <strong>criado</strong> com sucesso! Já está na fila de produção.";
            $request->getSession()->getFlashBag()->add("success", $msg);
            return $this->redirectToRoute("usuario_index");
        }
        
        return array("pedido"=>$pedido, "form"=>$form->createView());
    }


    /**
     * @Route("/cozinha/status", name="pedido_cozinha_status")
     */
    public function statusAction(Request $resquest) 
    {
        $response   = array('ok'=>0);
        $id         = $resquest->get("numero");
        $cancelar   = $resquest->get("cancelar");
        $status     = $resquest->get("status");
        
        if (is_null($id) || is_null($status)){
            $response['error'] = "Erro ao Alterar Status do pedido, Status ou ID não enviados!";
        } else {
            $em = $this->getDoctrine()->getManager();
            $pedido = $em->find(Pedido::class, $id);
            if (is_null($pedido)) {
                $response['error'] = "Erro ao alterar Status do Pedido produto não encontrado!";
            } else {
                if ($cancelar) {
                    $pedido->setCancelado(TRUE);
                } else {
                    if ($status == Pedido::CONCLUIDO) {
                        $pedido->setSituacao(Pedido::CONCLUIDO);
                    } else if ($status == Pedido::PRODUCAO) {
                        $pedido->setSituacao(Pedido::PRODUCAO);
                    }
                }
                
                try {
                    $em->merge($pedido);
                    $em->flush();
                    $response['ok'] = 1;
                    $response['success'] = "O Status do Pedido foi alterado com sucesso.";
                } catch (Exception $exc) {
                    $response['error'] = "Erro ao Alterar Status do Pedido, problema no banco de dados!";
                }
            }
        }
        $response['message'] = $this->renderView("ArmazemBarBundle::Messages/message.html.twig", $response);
        return new Response(json_encode($response));

    }

    
    
    
}
