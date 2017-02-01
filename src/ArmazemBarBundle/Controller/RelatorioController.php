<?php

namespace ArmazemBarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of RelatorioController
 * @Route("/relatorio")
 * @author Luciano
 */
class RelatorioController extends Controller
{
    
    /**
     * @Route("/", name="relatorio_index")
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
     * @Route("/gerar", name="relatorio_gerar")
     * @Template()
     */
    public function gerarAction(Request $request)
    {
        $periodoInicio = \DateTime::createFromFormat("d/m/Y", $request->get("inicio"));
        $periodoFim = \DateTime::createFromFormat("d/m/Y", $request->get("fim"));
        
        
        $pedidos = $this->getDoctrine()->getRepository(\ArmazemBarBundle\Entity\Pedido::class)->getRelatorio($periodoInicio, $periodoFim);
        return ['pedidos'=>$pedidos, 'tipo' => $request->get("tipo")];
    }
    
    
}
