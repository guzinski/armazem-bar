<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Controller;

use ArmazemBarBundle\Entity\Pedido;
use ArmazemBarBundle\Form\PedidoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of PedidoController
 *
 */
class PedidoController extends Controller
{
    
    
    
    /**
     * 
     * @Route("/pedido/novo", name="pedido_novo")
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
