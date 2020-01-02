<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Category;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WildController
 * @package App\Controller
 * @Route("/wild", name="wild_")
 */

class WildController extends AbstractController
{
    /**
     * Show all rows from Program’s entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();


        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }
        dump($programs);
        return $this->render(
            'wild/index.html.twig',
            ['programs' => $programs]
        );

    }
    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
     * @return Response
     */
    public function show(?string $slug):Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this
            ->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this
                ->createNotFoundException('No program with '.$slug.' title, found in program\'s table.');
        }
        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
        ]);
    }

    /**
     * @param string $categoryName
     * @Route("/category/{categoryName}", name="show_category")
     * @return Response
     */
    public function showByCategory(string $categoryName) : Response
    {
        $category = $this
            ->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name'=>$categoryName]);
        //$articles = $category->getArticles();
        $program = $this
            ->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['Category'=>$category->getId()],['id' => 'DESC'],3);
        return $this->render('wild/category.html.twig',
            [
                'category' => $categoryName,
                'programs' => $program
            ]
        );
    }
    /**
     * @Route("/program/{slug}", name="show_program")
     * @param string $programName
     * @return Response
     */
    public function showByProgram(?string $slug): Response
    {
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-"));

        if (!$slug) {
            throw $this
                ->createNotFoundException('Pas de série trouvée avec le titre '. $slug);
        }

        $repositoryProgram = $this->getDoctrine()->getRepository(Program::class);
        $program = $repositoryProgram->findOneBy(['title' => mb_strtolower($slug)]);
        $seasons = $program->getSeasons();
        return $this->render('wild/program.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
            'slug' => $slug,
        ]);
    }
    /**
     * @Route("/season/{id}", name="show_season")
     * @param int $id
     * @return Response
     */
    public function showBySeason(int $id): Response
    {
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $id]);
        $program = $season->getProgramId()->getTitle();
        $episodes = $season->getEpisodes();
        return $this->render('wild/season.html.twig', [
            'program' => $program,
            'episodes' => $episodes,
            'season' => $season,
        ]);
    }
   /**
     * @Route("/episode/{id}", name="show_episode")
     * @param Episode $episode
     * @return Response
     */
  public function showEpisode(Episode $episode): Response
    {
        $season = $episode->getSeason();
        $program = $season->getProgramid();
        return $this->render('wild/episode.html.twig', [
            'episode' => $episode,
            'season' => $season,
            'program' => $program,
        ]);
    }
}
