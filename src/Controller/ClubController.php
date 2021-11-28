<?php

namespace App\Controller;

use App\Entity\Club;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Symfony\Component\HttpFoundation\Request;

class ClubController extends AbstractController
{
    /**
     * @Route("/club", name="club")
     */
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }
     /**
     * @Route("/affichagec", name="affichagec")
     */
    public function affichage(ClubRepository $clubRepository)
    {
    $c = $clubRepository->findAll();

        return $this->render('club/afficheclub.html.twig',['listeclub'=>$c]);
    }

    /**
     * @Route("/modifierclub/{id}", name="modifierclub")
     * Method({"Get","POST"})
     */
    public function modifierclub(Request $request,$id)
    {
        $club = new Club();
        $club =$this->getDoctrine()->getRepository(Club::class)->find($id);
        $form = $this->createForm(ClubType::class,$club);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('affichagec');
        }
        return $this->render('club/modifierclub.html.twig',['form'=>$form->createView(),]);
    }

    /**
     * @Route("/deleteclub/{id}", name="deleteclub")
     */
    public function deleteclub($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cl = $em->getRepository(Club::class)
            ->find($id);
        $em->remove($cl);
        $em->flush();
        return $this->redirectToRoute("affichagec");
    }

    /**
     * @Route("/AddClub", name="AddClub")
     */
    public function AddClub(Request $request)
    {
        $club = new Club();
        $form = $this->createForm(ClubType::class,$club);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
            $club = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('affichagec');
        }
        return $this->render('club/ajouterclub.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
