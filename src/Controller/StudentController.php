<?php

namespace App\Controller;
use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    /**
     * @Route("/affichages", name="affichages")
     */
    public function affichage(StudentRepository $StudentRepository)
    {
    $s = $StudentRepository->findAll();

        return $this->render('student/affichestudent.html.twig',['listestudent'=>$s]);
    }

    /**
     * @Route("/modifierstudent/{id}", name="modifierstudent")
     * Method({"Get","POST"})
     */
    public function modifierclassroom(Request $request,$id)
    {
        $student = new Student();
        $student =$this->getDoctrine()->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class,$student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('affichages');
        }
        return $this->render('student/modifierstudent.html.twig',['form'=>$form->createView(),]);
    }

    /**
     * @Route("/deleteStudent/{id}", name="deleteStudent")
     */
    public function deleteStudent($id)
    {
        $em = $this->getDoctrine()->getManager();
        $stu = $em->getRepository(Student::class)
            ->find($id);
        $em->remove($stu);
        $em->flush();
        return $this->redirectToRoute("affichages");
    }

    /**
     * @Route("/AddStudent", name="AddStudent")
     */
    public function AddClassroom(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class,$student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
            $student = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute('affichages');
        }
        return $this->render('student/ajouterstudent.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
