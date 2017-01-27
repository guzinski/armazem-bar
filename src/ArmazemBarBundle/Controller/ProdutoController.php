<?php

namespace ArmazemBarBundle\Controller;

use ArmazemBarBundle\Entity\Produto;
use ArmazemBarBundle\Form\ProdutoType;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Description of ProdutoController
 * @Route("/produto")
 * @author Luciano
 */
class ProdutoController extends Controller
{
    
    /**
     * @Route("/", name="produto_index")
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
     * @Route("/pagination", name="produto_pagination")
     * @return Response
     */
    public function paginationAction()
    {
        $produtos = $this->getDoctrine()->getRepository(Produto::class)->findAll();
        $dados = array();
        foreach ($produtos as $produto) {
            /* @var $produto Produto  */
            $btnStatus = $produto->getAtivo() ? 
                    "<a title=\"Desativar\" class=\"btn btn-default btn-sm\" href=\"javascript:trocarStatus(".$produto->getId() .", 0);\"><i class=\"fa fa-remove\"></i></a>"
                    : "<a title=\"Ativar\" class=\"btn btn-default btn-sm\" href=\"javascript:trocarStatus(".$produto->getId() .", 1);\"><i class=\"fa fa-check\"></i></a>";
            $dados[] = [
                "<a title=\"Editar\"  href=\"".$this->generateUrl("produto_form", array("id"=>$produto->getId())) ."\"><span class=\"h4\">". $produto->getDescricao() ."</span></a>",
                $produto->getAtivo() ? "<em class='fa fa-check'></em>" : "<em class='fa fa-remove'></em>",
                "<div class=\"btn-group\">".$btnStatus."<a title=\"Excluir\" class=\"btn btn-default btn-sm\" href=\"javascript:excluir(".$produto->getId() .");\"><i class=\"glyphicon glyphicon-trash\"></i></a></div>",
            ];
        }
        $return['recordsTotal'] = count($produtos);
        $return['recordsFiltered'] = count($produtos);
        $return['data'] = $dados;
        return new Response(json_encode($return));
    }

    /**
     * 
     * @Route("/editar/{id}", name="produto_form")
     * @Template()
     */
    public function formAction(Request $request, $id = 0) 
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id>0) {
            $produto = $em->find(Produto::class, $id);
        } else {
            $produto = new Produto();
        }
        
        $form = $this->createForm(ProdutoType::class, $produto);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($produto);
            $em->flush();
            $msg = $id==0 ? "Produto <strong>incluído</strong> com sucesso." : "Produto <strong>alterado</strong> com sucesso.";
            $request->getSession()->getFlashBag()->add("success", $msg);
            return $this->redirectToRoute("produto_index");
        }
        
        return array("produto"=>$produto, "form"=>$form->createView());
    }
    
    /**
     * @Route("/excluir", name="produto_excluir")
     */
    public function excluiAction(Request $resquest) 
    {
        $response   = array('ok'=>0);
        $id         = $resquest->get("id");
        if (is_null($id)) {
            $response['error'] = "Erro ao excluir produto, ID vazio!";
        } else {
            $em = $this->getDoctrine()->getManager();
            $produto = $em->find(Produto::class, $id);
            if (is_null($produto)) {
                $response['error'] = "Erro ao excluir, produto não encontrado!";
            } else {
                if ($produto->getPedidoProdutos()->count()>0){
                    $response['error'] = "Não é possível excluir o produto, existem Pedidos vinculados!";
                } else {
                    try {
                        $em->remove($produto);
                        $em->flush();
                        $response['ok'] = 1;
                        $response['success'] = "Produto <strong>excluído</strong> com sucesso!";
                    } catch (Exception $exc) {
                        $response['error'] = "Erro ao excluir produto, problema com o banco de dados!";
                    }
                }
            }
        }
        $response['message'] = $this->renderView("ArmazemBarBundle::Messages/message.html.twig", $response);
        return new Response(json_encode($response));
    }
    
    /**
     * @Route("/alterarStatus", name="produto_status")
     */
    public function statusAction(Request $resquest) 
    {
        $response   = array('ok'=>0);
        $id         = $resquest->get("id");
        $status     = $resquest->get("status");
        
        if (is_null($id) || is_null($status)){
            $response['error'] = "Erro ao Alterar Status do produto, Status ou ID não enviados!";
        } else {
            $strStatus = $status ? "Ativar" : "Desativar";
            $em = $this->getDoctrine()->getManager();
            $produto = $em->find(Produto::class, $id);
            if (is_null($produto)) {
                $response['error'] = "Erro ao ".$strStatus.", produto não encontrado!";
            } else {
                if ($status) {
                    $produto->setAtivo(TRUE);
                } else {
                    $produto->setAtivo(FALSE);
                }
                
                try {
                    $em->merge($produto);
                    $em->flush();
                    $response['ok'] = 1;
                    $response['success'] = "O Status do Produto foi alterado com sucesso.";
                } catch (Exception $exc) {
                    $response['error'] = "Erro ao ".$strStatus.", produto, problema no banco de dados!";
                }
            }
        }
        $response['message'] = $this->renderView("ArmazemBarBundle::Messages/message.html.twig", $response);
        return new Response(json_encode($response));

    }

    
    /**
     * @Route("/preco/venda", name="produto_preco_venda")
     * @param Request $request
     * @return Response
     */
    public function precoVendaAction(Request $request)
    {
        $produto = $request->get("produto");
        if (empty($produto)) {
            throw new InvalidArgumentException;
        }
        
        $produto = $this->getDoctrine()->getRepository(Produto::class)->find($produto);
        
        if (empty($produto)) {
            throw new NotFoundHttpException;
        }
        
        
        return new Response($produto->getPrecoVenda());
    }

    
}
