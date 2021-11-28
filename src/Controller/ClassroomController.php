<?php
namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
     /**
     * @Route("/affichage", name="affichage")
     */
    public function affichage(ClassroomRepository $classroomRepository)
    {
    $c = $classroomRepository->findAll();

        return $this->render('classroom/afficheclassroom.html.twig',['listeclassroom'=>$c]);
    }

    /**
     * @Route("/modifierclassroom/{id}", name="modifierclassroom")
     * Method({"Get","POST"})
     */
    public function modifierclassroom(Request $request,$id)
    {
        $classroom = new Classroom();
        $classroom =$this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $form = $this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('affichage');
        }
        return $this->render('classroom/modifierclassroom.html.twig',['form'=>$form->createView(),]);
    }

    /**
     * @Route("/deleteClassroom/{id}", name="deleteClassroom")
     */
    public function deleteClassroom($id)
    {
        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository(Classroom::class)
            ->find($id);
        $em->remove($classe);
        $em->flush();
        return $this->redirectToRoute("affichage");
    }

    /**
     * @Route("/AddClassroom", name="AddClassroom")
     */
    public function AddClassroom(Request $request)
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
            $classroom = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classroom);
            $entityManager->flush();
            return $this->redirectToRoute('affichage');
        }
        return $this->render('classroom/ajouterclassroom.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
