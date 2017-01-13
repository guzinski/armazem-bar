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
        return array('incluido'=>$request->get('incluido'));
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
            
            $linha[] = "<a href=\"".$this->generateUrl("usuario_form", array("id"=>$usuario->getId())) ."\">". $usuario->getNome() ."</a>";
            $linha[] = $usuario->getEmail();
            $linha[] = "<a href=\"javascript:excluirUsuario(".$usuario->getId() .");\"><i class=\"glyphicon glyphicon-trash\"></a>";
            $dados[] = $linha;
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
        if ($form->isValid()) {
            $em->persist($usuario);
            $em->flush();
            return $this->redirectToRoute("usuario_index", ['incluido' => true]);
        }
        
        return array("usuario"=>$usuario, "form"=>$form->createView());
    }

    /**
     * @Route("/excluir", name="usuario_excluir")
     */
    public function excluiAction(Request $resquest) 
    {
        $respone = array();
        $id = $resquest->request->getInt("id", null);
        if (null != $id) {
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->find(Usuario::class, $id);
            $em->remove($usuario);
            $em->flush();
            $respone['ok'] = 1;
        } else {
            $respone['ok'] = 0;
            $respone['error'] = "Erro ao exclui usuário";
        }
        return new Response(json_encode($respone));
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
