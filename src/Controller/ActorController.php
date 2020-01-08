<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Repository\ActorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/actor")
 */
class ActorController extends AbstractController
{
    /**
     * @Route("/", name="actor_index")
     */
    public function index(ActorRepository $actorRepository)
    {
        $actors = $actorRepository->findAll();

        return $this->render('Actor/index.html.twig', [
            'actors' => $actors
        ]);
    }
    /**
     * @Route("/{id}", name="actor_show", methods={"GET"})
     * @param Actor $actor
     * @return Response
     */
    public function show(Actor $actor): Response
    {
        return $this->render('Actor/show.html.twig', [
            'actor' => $actor,
            'programs'=> $actor->getPrograms()
            ]);
    }

}
