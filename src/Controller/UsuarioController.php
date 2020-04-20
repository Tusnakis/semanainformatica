<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Usuario;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends AbstractController
{
    /**
    * @Route("/nuevousuario", name="nuevo_usuario")
    */
    public function nuevo_usuario(Request $request)
    {
        $usuario = new Usuario();

        $formulario = $this->createFormBuilder($usuario)
            ->add('user', TextType::class, array('label' => 'Nombre de Usuario'))
            ->add('pass', TextType::class, array('label' => 'Password'))
            ->add('email', TextType::class, array('label' => 'Email'))
            ->add('rol', TextType::class, array('label' => 'Rol (ROLE_ADMIN o ROLE_USER)'))
            ->add('save', SubmitType::class, array('label' => 'Añadir'))
            ->getForm();
            
        $formulario->handleRequest($request);

        if($formulario->isSubmitted() && $formulario->isValid())
        {
            $usuario = $formulario->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usuario);
            $entityManager->flush();
            return $this->redirectToRoute('inicio');
        }
            
        return $this->render('nuevo_usuario.html.twig', array('formulario' => $formulario->createView()));
    }
}

?>