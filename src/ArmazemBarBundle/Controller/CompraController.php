<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Controller;

use ArmazemBarBundle\Entity\Compra;
use ArmazemBarBundle\Entity\CompraBebida;
use ArmazemBarBundle\Form\CompraType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $success = "";
        if ($request->getSession()->getFlashBag()->has("success")) {
            $success = $request->getSession()->getFlashBag()->get("success");
            $request->getSession()->getFlashBag()->clear();
        }
        
        return array('success' => $success);
    }
    
    
    /**
     * @Route("/compra", name="compra_pagination")
     * @return Response
     */
    public function paginationAction()
    {
        $compras = $this->getDoctrine()->getRepository(Compra::class)->findAll();
        $dados = [];
        foreach ($compras as $compra) {
            /* @var $compra Compra  */
            $compraBebidas = [];
            foreach ($compra->getCompraBebidas() as $compraBebida) {
                /* @var $compraBebida CompraBebida  */
                $compraBebidas[] = [
                    'bebida' => $compraBebida->getBebida()->getDescricao(),
                    'quantidade' => $compraBebida->getQuantidade(),
                ];
            }
            
            $dados[] = [
                'data_compra' => $compra->getData()->format("d/m/Y"),
                'compra_bebidas' => $compraBebidas,
            ];            
        }
        $return['recordsTotal'] = count($compras);
        $return['recordsFiltered'] = count($compras);
        $return['data'] = $dados;
        return new Response(json_encode($return));
    }

    
    /**
     * 
     * @Route("/editar/{id}", name="compra_form")
     * @Template()
     */
    public function formAction(Request $request, $id = 0) 
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id>0) {
            $compra = $em->find(Compra::class, $id);
        } else {
            $compra = new Compra();
        }
        
        $form = $this->createForm(CompraType::class, $compra);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($compra);
            $em->flush();
            $msg = $id==0 ? "Compra <strong>incluída</strong> com sucesso." : "Compra <strong>alterada</strong> com sucesso.";
            $request->getSession()->getFlashBag()->add("success", $msg);
            return $this->redirectToRoute("compra_index");
        }
        
        return array("compra"=>$compra, "form"=>$form->createView());
    }

    
    
    
    
}
