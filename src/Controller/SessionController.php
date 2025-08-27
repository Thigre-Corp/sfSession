<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




final class SessionController extends AbstractController
{



    #[Route('/session', name: 'app_session')]
    public function index(EntityManagerInterface $entityManager,  Request $request): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionFormType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }

        $activeSessions = $entityManager->getRepository(Session::class)->findActiveSessions();
        $pastSessions = $entityManager->getRepository(Session::class)->findPastSessions();
        $futureSessions = $entityManager->getRepository(Session::class)->findFutureSessions();


        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
            'activeSessions' => $activeSessions,
            'lastSessions' =>$pastSessions,
            'futureSessions' =>$futureSessions,
            'formAddSession' => $form,
        ]);
    }




    #[Route('/session_edit&id={id}', name: 'edit_session')]
    public function edit(Session $session) : Response
    {
        return $this->render('session/Edit.html.twig', [
            'controller_name' => 'Edit - SessionController',
            'session' => $session
        ]);
    }

    #[Route('/session&id={id}', name: 'show_session')]
    public function show(Session $session , EntityManagerInterface $entityManager) : Response
    {

        $learnersNotInSession = $entityManager->getRepository(Stagiaire::class)->learnersNotInSession($session);


        return $this->render('session/show.html.twig', [
            'controller_name' => 'show - SessionController',
            'session' => $session,
            'learnersNotInSession' =>$learnersNotInSession,
        ]);
    }
}
