<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionFormType;
use App\Form\SessionSearchType;
use Symfony\Component\Form\FormView;
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
        
        //formulaire recherche de session par le nom
        $searchSession = new Session();
 
        $formSearch = $this->createForm(SessionSearchType::class, $searchSession);

        $formSearch->handleRequest($request);
    
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            $foundSessions = $entityManager->getRepository(Session::class)->foundSessions($searchSession);

            if (!$foundSessions){
                $this->addFlash(
                    'warning',
                    'Aucun résultat pour cette recherche'
                );
            }

            //si null -> message flash "pas de résultat pour cette demande"
            //dd($foundSessions);
        }

        //formulaire création de session
        $session = new Session();

        $form = $this->createForm(SessionFormType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }

        //récupération des sessions à afficher SI $foundSessions est null
        $activeSessions = $entityManager->getRepository(Session::class)->findActiveSessions();
        $pastSessions = $entityManager->getRepository(Session::class)->findPastSessions();
        $futureSessions = $entityManager->getRepository(Session::class)->findFutureSessions();


        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
            'activeSessions' => $activeSessions,
            'pastSessions' =>$pastSessions,
            'futureSessions' =>$futureSessions,
            'formAddSession' => $form,
            'form' => $formSearch->createView(),
            'auth' => true ,
            'foundSessions' => $foundSessions ?? null,
        ]);
    }

    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function edit(Session $session) : Response
    {
        return $this->render('session/Edit.html.twig', [
            'controller_name' => 'Edit - SessionController',
            'session' => $session
        ]);
    }

    #[Route('/session/{id}/delete', name: 'delete_session')]
    public function delete(EntityManagerInterface $entityManager, Session $session) : Response
    {
        $nom = $session->getNom();
        $entityManager->remove($session);
        $entityManager->flush();

        $this->addFlash(
                    'warning',
                    $nom.' supprimé'
                );

        return $this->redirectToRoute('app_session');
    }

    #[Route('/session/{id}', name: 'show_session')]
    public function show(Request $request, Session $session , EntityManagerInterface $entityManager) : Response
    {

        $learnersNotInSession = $entityManager->getRepository(Session::class)->learnersNotInSession($session);
        $modulesNotInSession = $entityManager->getRepository(Session::class)->modulesNotInSession($session);

        return $this->render('session/show.html.twig', [
            'controller_name' => 'show - SessionController',
            'session' => $session,
            'learnersNotInSession' => $learnersNotInSession,
            'modulesNotInSession' => $modulesNotInSession
        ]);
    }
}
