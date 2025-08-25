<?php

namespace App\Controller;

use App\Entity\Session;
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

        $sessions = $entityManager->getRepository(Session::class)->findAll();

        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
            'sessions' => $sessions,
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
    public function show(Session $session) : Response
    {
        return $this->render('session/show.html.twig', [
            'controller_name' => 'show - SessionController',
            'session' => $session
        ]);
    }
}
