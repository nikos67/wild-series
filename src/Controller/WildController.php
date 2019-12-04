<?php
// src/Controller/WildController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class WildController extends AbstractController

{
    /**
     * @Route("/wild", name="wild_index")
     * @return Response
     */

    public function index() : Response
    {
        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }

    /**
     * @param string $slug
     * @Route("/wild/show/{slug}", requirements={"slug"="[a-z0-9-]+"}, name="wild_show")
     * @return Response
     */

    public function show(string $slug =' '): Response
    {
        $slug = ucwords(str_replace('-', ' ', $slug));
        return $this->render('wild/show.html.twig', ['slug' => $slug]);

    }

}

