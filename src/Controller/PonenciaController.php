<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Ponencia;
use App\Entity\Categoriaponencia;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;

class PonenciaController extends AbstractController
{

    /**
     * @Route("/ponencias", name="ponencias")
     */
    public function ponencias()
    {
        $repositorio = $this->getDoctrine()->getRepository(Ponencia::class);
        $ponencias = $repositorio->findAll();
        return $this->render('lista_ponencias.html.twig', array('ponencias' => $ponencias));
    }

    /**
    * @Route("/nuevaponencia", name="nueva_ponencia")
    */
    public function nueva_ponencia(Request $request)
    {
        $ponencia = new Ponencia();

        $formulario = $this->createFormBuilder($ponencia)
            ->add('titulopo', TextType::class, array('label' => 'Titulo de la Ponencia'))
            ->add('categoriaponencia', EntityType::class, array(
                'class' => Categoriaponencia::class,
                'choice_label' => 'nombre',
                'label' => 'Categoria Ponencia',
            ))
            ->add('likepo', HiddenType::class, array('label' => 'Likes','empty_data' => '0'))
            ->add('save', SubmitType::class, array('label' => 'Añadir'))
            ->getForm();
            
        $formulario->handleRequest($request);

        if($formulario->isSubmitted() && $formulario->isValid())
        {
            $ponencia = $formulario->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ponencia);
            $entityManager->flush();
            return $this->redirectToRoute('ponencias');
        }
            
        return $this->render('nueva_ponencia.html.twig', array('formulario' => $formulario->createView()));
    }

    /**
     * @Route("/eliminarponencia/{id}", name="eliminar_ponencia")
     */
    public function eliminar_ponencia($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repositorio = $this->getDoctrine()->getRepository(Ponencia::class);
        $ponencia = $repositorio->find($id);
        if($ponencia)
        {
            $entityManager->remove($ponencia);
            $entityManager->flush();
        }
        return $this->redirectToRoute('ponencias');
    }

    /**
     * @Route("/editarponencia/{id}", name="editar_ponencia")
     */
    public function editar_ponencia(Request $request, $id)
    {
        $repositorio = $this->getDoctrine()->getRepository(Ponencia::class);
        $ponencia = $repositorio->find($id);

        $formulario = $this->createFormBuilder($ponencia)
            ->add('titulopo', TextType::class, array('label' => 'Titulo de la Ponencia'))
            ->add('categoriaponencia', EntityType::class, array(
                'class' => Categoriaponencia::class,
                'choice_label' => 'nombre',
                'label' => 'Categoria Ponencia',
            ))
            ->add('likepo', IntegerType::class, array('label' => 'Likes'))
            ->add('save', SubmitType::class, array('label' => 'Modificar'))
            ->getForm();
            
        $formulario->handleRequest($request);

        if($formulario->isSubmitted() && $formulario->isValid())
        {
            $ponencia = $formulario->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ponencia);
            $entityManager->flush();
            return $this->redirectToRoute('ponencias');
        }
            
        return $this->render('editar_ponencia.html.twig', array('formulario' => $formulario->createView()));
    }

    /**
     * @Route("/aumentarlikepo/{id}", name="aumentar_likepo")
     */
    public function aumentar_likepo($id)
    {
        $repositorio = $this->getDoctrine()->getRepository(Ponencia::class);
        $ponencia = $repositorio->find($id);
        $ponencia->setLikepo($ponencia->getLikepo() + 1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($ponencia);
        $entityManager->flush();
        return $this->redirectToRoute('ponencias');
    }

    /**
     * @Route("/disminuirlikepo/{id}", name="disminuir_likepo")
     */
    public function disminuir_likepo($id)
    {
        $repositorio = $this->getDoctrine()->getRepository(Ponencia::class);
        $ponencia = $repositorio->find($id);
        if($ponencia->getLikepo() == 0)
        {
            $ponencia->setLikepo(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ponencia);
            $entityManager->flush();
            return $this->redirectToRoute('ponencias');
        }
        else
        {
            $ponencia->setLikepo($ponencia->getLikepo() - 1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ponencia);
            $entityManager->flush();
            return $this->redirectToRoute('ponencias');
        }
    }

}

?>