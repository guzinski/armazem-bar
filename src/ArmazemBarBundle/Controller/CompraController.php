<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Controller;

use ArmazemBarBundle\Entity\Compra;
use ArmazemBarBundle\Form\CompraType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of CompraController
 * @Route("/compra")
 * @author Luciano
 */
class CompraController extends Controller
{
    /**
     * @Route("/", name="compra_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        return [];
    }
    
    /**
     * 
     * @Route("/editar/{id}", name="compra_form")
     * @Template()
     */
    public function formAction(Request $request, $id = 0) 
    {
        $em = $this->getDoctrine()->getManager();
        
//        if ($id>0) {
//            $bebida = $em->find(Bebida::class, $id);
//        } else {
//            $bebida = new Bebida();
//        }
        
        $compra = new Compra();
        $form = $this->createForm(CompraType::class, $compra);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($compra);
            $em->flush();
            return $this->redirectToRoute("compra_index");
        }
        
        return array("compra"=>$compra, "form"=>$form->createView());
    }

    
    
    
    
}
