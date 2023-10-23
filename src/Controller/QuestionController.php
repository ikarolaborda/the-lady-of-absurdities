<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    public function __construct(private LoggerInterface $logger, private bool $isDebug)
    {
    }

    #[Route(path: '/{_locale}/{page<\d+>}', name: 'app_homepage', requirements: ['_locale' => 'en|pt'], defaults: ['_locale' => 'pt'])]
    public function homepage(QuestionRepository $repository, int $page = 1): Response
    {
        $queryBuilder = $repository->createAskedOrderedByNewestQueryBuilder();
        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
        $pagerfanta->setMaxPerPage(5);
        $pagerfanta->setCurrentPage($page);

        return $this->render('question/homepage.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }

    #[Route(path: '/{_locale}/questions/new', requirements: ['_locale' => 'en|pt'], defaults: ['_locale' => 'pt'])]
    #[IsGranted('ROLE_USER')]
    public function new(): Response
    {
        return new Response('Sounds like a GREAT feature for V2!');
    }

    #[Route(path: '/{_locale}/questions/{slug}', name: 'app_question_show', requirements: ['_locale' => 'en|pt'], defaults: ['_locale' => 'en'])]
    public function show(Question $question): Response
    {
        if ($this->isDebug) {
            $this->logger->info('We are in debug mode!');
        }

        return $this->render('question/show.html.twig', [
            'question' => $question,
        ]);
    }

    #[Route(path: '/{_locale}/questions/edit/{slug}', name: 'app_question_edit', requirements: ['_locale' => 'en|pt'], defaults: ['_locale' => 'pt'])]
    public function edit(Question $question): Response
    {
        $this->denyAccessUnlessGranted('EDIT', $question);

        return $this->render('question/edit.html.twig', [
            'question' => $question,
        ]);
    }

    #[Route(path: '/{_locale}/questions/{slug}/vote', name: 'app_question_vote', requirements: ['_locale' => 'en|pt'], defaults: ['_locale' => 'pt'], methods: 'POST')]
    public function questionVote(Question $question, Request $request, EntityManagerInterface $entityManager): Response
    {
        $direction = $request->request->get('direction');
        if ($direction === 'up') {
            $question->upVote();
        } elseif ($direction === 'down') {
            $question->downVote();
        }
        $entityManager->flush();

        return $this->redirectToRoute('app_question_show', [
            'slug' => $question->getSlug(),
        ]);
    }
}