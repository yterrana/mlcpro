<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\SearchType;
use App\Repository\JobRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/jobs", name="jobs_grid")
     */
    public function jobGrid(Request $request, JobRepository $jobRepository, ObjectManager $manager, PaginatorInterface $paginator)
    {
        $jobs = $manager->getRepository(Job::class)->findAll();
        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $criteria = $searchForm->getData();
            $jobs = $jobRepository->searchJobs($criteria);
        }

        $pagination = $paginator->paginate(
            $jobs,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('search/job_grid.html.twig', [
            'jobs' => $pagination,
            'searchForm' => $searchForm->createView(),
        ]);
    }
}
