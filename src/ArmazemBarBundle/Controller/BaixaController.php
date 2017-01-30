<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ArmazemBarBundle\Controller;

use ArmazemBarBundle\Entity\Baixa;
use ArmazemBarBundle\Entity\CompraBebida;
use ArmazemBarBundle\Form\BaixaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of BaixaController
 * @Route("/baixa")
 */
class BaixaController extends Controller
{
    /**
     * @Route("/", name="baixa_index")
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
     * @Route("/baixa", name="baixa_pagination")
     * @return Response
     */
    public function paginationAction()
    {
        $baixas = $this->getDoctrine()->getRepository(Baixa::class)->findAll();
        $dados = [];
        foreach ($baixas as $baixa) {
            /* @var $baixa Baixa  */
            $baixaBebidas = [];
            foreach ($baixa->getBaixaBebidas() as $baixaBebida) {
                /* @var $baixaBebida CompraBebida  */
                $baixaBebidas[] = [
                    'bebida' => $baixaBebida->getBebida()->getDescricao(),
                    'quantidade' => $baixaBebida->getQuantidade(),
                ];
            }
            
            $dados[] = [
                'data_compra' => $baixa->getData()->format("d/m/Y"),
                'baixa_bebidas' => $baixaBebidas,
            ];            
        }
        $return['recordsTotal'] = count($baixas);
        $return['recordsFiltered'] = count($baixas);
        $return['data'] = $dados;
        return new Response(json_encode($return));
    }
    
    
    
    /**
     * 
     * @Route("/editar/{id}", name="baixa_form")
     * @Template()
     */
    public function formAction(Request $request, $id = 0) 
    {
        $em = $this->getDoctrine()->getManager();
        if ($id>0) {
            $baixa = $em->find(Baixa::class, $id);
        } else {
            $baixa = new Baixa();
        }
        
        $form = $this->createForm(BaixaType::class, $baixa);

        $form->handleRequest($request);
        echo "aqui 2";
        echo "aqui 2";
        if ($form->isSubmitted() && $form->isValid()) {
            echo "aqui 3";
            $em->persist($baixa);
            echo "aqui";
            $em->flush();
            echo "aqui 4";
            $msg = $id==0 ? "baixa <strong>incluída</strong> com sucesso." : "Baixa <strong>alterada</strong> com sucesso.";
            $request->getSession()->getFlashBag()->add("success", $msg);
            return $this->redirectToRoute("baixa_index");
        }
        
        return array("baixa"=>$baixa, "form"=>$form->createView());
    }

    
    
    
}
