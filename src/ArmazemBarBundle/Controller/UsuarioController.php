<?php

namespace ArmazemBarBundle\Controller;

use ArmazemBarBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ArmazemBarBundle\Form\UsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * UsuarioController
 * @Route("/usuario")
 * @author Luciano
 */
class UsuarioController extends Controller
{    
    /**
     * @Route("/", name="usuario_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        return array('incluido'=>$request->get('incluido'), 'alterado'=>$request->get('alterado'));
    }

    /**
     * @Route("/pagination", name="usuario_pagination")
     * @return Response
     */
    public function paginationAction()
    {
        $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->findAll();
        $dados = array();
        foreach ($usuarios as $usuario) {
            $linha = array();
            $dados[] = [
                "<a href=\"".$this->generateUrl("usuario_form", array("id"=>$usuario->getId())) ."\"><span class=\"h4\">". $usuario->getNome() ."</span></a>",
                $usuario->getEmail(),
                "<a title=\"Excluir\" class=\"btn btn-default btn-sm\" href=\"javascript:excluir(".$usuario->getId() .");\"><i class=\"glyphicon glyphicon-trash\"></i></a>",
            ];
        }
        $return['recordsTotal'] = count($usuarios);
        $return['recordsFiltered'] = count($usuarios);
        $return['data'] = $dados;
        return new Response(json_encode($return));
    }

    
    /**
     * 
     * @Route("/editar/{id}", name="usuario_form")
     * @Template()
     */
    public function formAction(Request $request, $id = 0) 
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id>0) {
            $usuario = $em->find(Usuario::class, $id);
        } else {
            $usuario = new Usuario();
        }
        
        $form = $this->createForm(UsuarioType::class, $usuario);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($usuario);
            $em->flush();
            return $this->redirectToRoute("usuario_index", ['incluido' => !($id>0), 'alterado'=> ($id>0)]);
        }
        
        return array("usuario"=>$usuario, "form"=>$form->createView());
    }

    /**
     * @Route("/excluir", name="usuario_excluir")
     */
    public function excluiAction(Request $resquest) 
    {
        $response   = array("ok"=>0);
        $id         = $resquest->get("id", null);
        if (!is_null($id)) {
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->find(Usuario::class, $id);
            
            if (is_null($usuario)) {
                $response['error'] = "Erro ao excluir, usuário não encontrado!";
                return new Response(json_encode($response));
            }
            try {
                $em->remove($usuario);
                $em->flush();
                $response['ok'] = 1;
            } catch (Exception $exc) {
                $response['error'] = "Erro ao excluir usuário, problema com o banco de dados!";
            }
        } else {
            $response['error'] = "Erro ao excluir usuário, ID vazio!";
        }
        return new Response(json_encode($response));
    }
    
    /**
     * @Route("/trocar/senha", name="trocar_senha")
     * @Template()
     */
    public function trocarSenhaAction()
    {
        return array();
    }

    
    
    

    
}
