<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Taller;
use App\Entity\Categoriataller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;

class TallerController extends AbstractController
{

    /**
     * @Route("/talleres", name="talleres")
     */
    public function talleres()
    {
        $repositorio = $this->getDoctrine()->getRepository(Taller::class);
        $talleres = $repositorio->findAll();
        return $this->render('lista_talleres.html.twig', array('talleres' => $talleres));
    }

    /**
    * @Route("/nuevotaller", name="nuevo_taller")
    */
    public function nuevo_taller(Request $request)
    {
        $taller = new Taller();

        $formulario = $this->createFormBuilder($taller)
            ->add('titulota', TextType::class, array('label' => 'Titulo del Taller'))
            ->add('categoriataller', EntityType::class, array(
                'class' => Categoriataller::class,
                'choice_label' => 'nombre',
                'label' => 'Categoria Taller',
            ))
            ->add('liketa', HiddenType::class, array('label' => 'Likes','empty_data' => '0'))
            ->add('save', SubmitType::class, array('label' => 'Añadir'))
            ->getForm();
            
        $formulario->handleRequest($request);

        if($formulario->isSubmitted() && $formulario->isValid())
        {
            $taller = $formulario->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taller);
            $entityManager->flush();
            return $this->redirectToRoute('talleres');
        }
            
        return $this->render('nuevo_taller.html.twig', array('formulario' => $formulario->createView()));
    }

    /**
     * @Route("/eliminartaller/{id}", name="eliminar_taller")
     */
    public function eliminar_taller($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repositorio = $this->getDoctrine()->getRepository(Taller::class);
        $taller = $repositorio->find($id);
        if($taller)
        {
            $entityManager->remove($taller);
            $entityManager->flush();
        }
        return $this->redirectToRoute('talleres');
    }

    /**
     * @Route("/editartaller/{id}", name="editar_taller")
     */
    public function editar_taller(Request $request, $id)
    {
        $repositorio = $this->getDoctrine()->getRepository(Taller::class);
        $taller = $repositorio->find($id);

        $formulario = $this->createFormBuilder($taller)
            ->add('titulota', TextType::class, array('label' => 'Titulo del Taller'))
            ->add('categoriataller', EntityType::class, array(
                'class' => Categoriataller::class,
                'choice_label' => 'nombre',
                'label' => 'Categoria Taller',
            ))
            ->add('liketa', IntegerType::class, array('label' => 'Likes'))
            ->add('save', SubmitType::class, array('label' => 'Modificar'))
            ->getForm();
            
        $formulario->handleRequest($request);

        if($formulario->isSubmitted() && $formulario->isValid())
        {
            $taller = $formulario->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taller);
            $entityManager->flush();
            return $this->redirectToRoute('talleres');
        }
            
        return $this->render('editar_taller.html.twig', array('formulario' => $formulario->createView()));
    }

    /**
     * @Route("/aumentarliketa/{id}", name="aumentar_liketa")
     */
    public function aumentar_liketa($id)
    {
        $repositorio = $this->getDoctrine()->getRepository(Taller::class);
        $taller = $repositorio->find($id);
        $taller->setLiketa($taller->getLiketa() + 1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($taller);
        $entityManager->flush();
        return $this->redirectToRoute('talleres');
    }

    /**
     * @Route("/disminuirliketa/{id}", name="disminuir_liketa")
     */
    public function disminuir_liketa($id)
    {
        $repositorio = $this->getDoctrine()->getRepository(Taller::class);
        $taller = $repositorio->find($id);
        if($taller->getLiketa() == 0)
        {
            $taller->setLiketa(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taller);
            $entityManager->flush();
            return $this->redirectToRoute('talleres');
        }
        else
        {
            $taller->setLiketa($taller->getLiketa() - 1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($taller);
            $entityManager->flush();
            return $this->redirectToRoute('talleres');
        }
    }

}

?>