<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\SearchType;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, JobRepository $jobRepository, EntityManagerInterface $manager)
    {
        $jobs = $manager->getRepository(Job::class)->findBy([], ['posted_at' => 'DESC'], 5);
        $jobsCount = count($jobs);
        $searchForm = $this->createForm(SearchType::class);

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $criteria = $searchForm->getData();
            $jobs = $jobRepository->searchJobs($criteria);

            return $this->render('search/job_grid.html.twig', [
                'jobs' => $jobs,
                'searchForm' => $searchForm->createView(),
            ]);
        }

        return $this->render('home/index.html.twig', [
            'jobs' => $jobs,
            'jobsCount' => $jobsCount,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * @Route("/about/vfc", name="about_vfc")
     */
    public function aboutVfc()
    {

        return $this->render('home/about_vfc.html.twig');
    }

    /**
     * @Route("/job/details/{id}", name="job_details")
     */
    public function jobDetails($id, EntityManagerInterface $manager)
    {
        setlocale(LC_TIME, "fr_FR");
        $job = $manager->getRepository(Job::class)->find($id);

        return $this->render('home/job_details.html.twig', [
            'job' => $job,
        ]);
    }

    /**
     * @Route("/ajax", name="ajax")
     */
    public function searchRegion(Request $request)
    {
        $nom = $request->query->get('term');
        $output = file_get_contents('https://geo.api.gouv.fr/departements?nom='.$nom.'&limit=5');
        $outputDec = json_decode($output, true);
        $res = array();
        foreach ($outputDec AS $val) {
            $res[] = array('value' => $val['nom'], 'id' => $val['nom']);
        }
        return new JsonResponse($res);
    }
}
