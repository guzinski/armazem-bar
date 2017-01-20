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
            /* @var $pedido Pedido  */
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
            
            $dados[] = [
                'numero'            => $pedido->getId(),
                'data_pedido'       => $pedido->getDataCadastro()->format("d/m/Y"),
                'pedido_bebidas'    => $pedidoBebidas,
                'pedido_produtos'   => $pedidoProdutos,
                'situacao'            => $pedido->getStringSituacao(),
            ];            
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

    
    
    
}
