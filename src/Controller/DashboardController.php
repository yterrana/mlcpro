<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Job;
use App\Entity\JobName;
use App\Form\JobNameType;
use App\Form\JobType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_OWNER")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard_applications")
     */
    public function spontaneousApplications(Request $request, EntityManagerInterface $manager, PaginatorInterface $paginator)
    {
        $spontaneous_applications = $manager->getRepository(Application::class)->findBy([
            'appForJob' => false
        ],[
            'uploaded_at' => 'DESC'
        ]);

        $spontaneous_applicationsNb = count($spontaneous_applications);

        $pagination_applications = $paginator->paginate(
            $spontaneous_applications,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('dashboard/spontaneous_applications.html.twig', [
            'applications' => $pagination_applications,
            'spontaneous_applicationsNb' => $spontaneous_applicationsNb,
        ]);
    }

    /**
     * @Route("/dashboard/applications", name="applications")
     */
    public function applications(Request $request, EntityManagerInterface $manager, PaginatorInterface $paginator)
    {
        $applications = $manager->getRepository(Application::class)->findBy([
            'appForJob' => true
        ],[
            'uploaded_at' => 'DESC'
        ]);

        $applicationsNb = count($applications);

        $pagination_applications = $paginator->paginate(
            $applications,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('dashboard/applications.html.twig', [
            'applications' => $pagination_applications,
            'applicationsNb' => $applicationsNb,
        ]);
    }

    /**
     * @Route("/application/delete/{id}", name="delete_application")
     */
    public function deleteApplication($id)
    {
        $em = $this->getDoctrine()->getManager();
        $applicationToDelete = $em->getRepository(Application::class)->find($id);

        $zip = $this->getParameter('applications_directory').'/'.$applicationToDelete->getToken().'.zip';
        if (file_exists($zip)) {
            unlink($this->getParameter('applications_directory').'/'.$applicationToDelete->getToken().'.zip');
        }

        $em->remove($applicationToDelete);
        $em->flush();

        $this->addFlash('success', 'Candidature supprimée avec succès !');

        return $this->redirectToRoute('dashboard_applications');
    }

    /**
     * @Route("/applicationForJob/delete/{id}", name="delete_applicationForJob")
     */
    public function deleteapplicationForJob($id)
    {
        $em = $this->getDoctrine()->getManager();
        $applicationToDelete = $em->getRepository(Application::class)->find($id);

        $zip = $this->getParameter('applications_directory').'/'.$applicationToDelete->getToken().'.zip';
        if (file_exists($zip)) {
            unlink($this->getParameter('applications_directory').'/'.$applicationToDelete->getToken().'.zip');
        }

        $em->remove($applicationToDelete);
        $em->flush();

        $this->addFlash('success', 'Candidature supprimée avec succès !');

        return $this->redirectToRoute('applications');
    }

    /**
     * @Route("/dashboard/job", name="dashboard_jobs")
     */
    public function jobs(Request $request, ObjectManager $manager, PaginatorInterface $paginator)
    {
        $jobs = $manager->getRepository(Job::class)->findBy([],[
            'title' => 'asc',
            'posted_at' => 'DESC',
        ]);

        $jobsNb = count($jobs);

        $pagination = $paginator->paginate(
            $jobs,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('dashboard/jobs.html.twig', [
            'jobs' => $pagination,
            'jobsNb' => $jobsNb
        ]);
    }

    /**
     * @Route("/dashboard/job/add", name="add_job")
     */
    public function addJob(Request $request, ObjectManager $manager)
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($job);
            $manager->flush();

            $this->addFlash('success', 'L\'offre d\'emploi a bien été ajoutée !');

            return $this->redirectToRoute('dashboard_jobs');
        }

        return $this->render('dashboard/add_job.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("dashboard/job/delete/{id}", name="delete_job")
     */
    public function deleteJob($id)
    {
        $em = $this->getDoctrine()->getManager();
        $jobToDelete = $em->getRepository(Job::class)->find($id);
        $applications = $em->getRepository(Application::class)->findBy(['job' => $id]);

        foreach ($applications as $app) {
            $token = $app->getToken();
            if (file_exists($this->getParameter('applications_directory').'/'.$token.'.zip')) {
                unlink($this->getParameter('applications_directory').'/'.$token.'.zip');
            }
        }

        $em->remove($jobToDelete);
        $em->flush();

        $this->addFlash('success', 'Offre d\'emploi supprimée avec succès !');

        return $this->redirectToRoute('dashboard_jobs');
    }

    /**
     * @Route("dashboard/job/edit/{id}", name="edit_job", methods={"GET", "POST"})
     */
    public function editJob(Request $request, Job $job)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Offre d\'emploi modifiée avec succès !');

            return $this->redirectToRoute('dashboard_jobs');
        }

        return $this->render('dashboard/edit_job.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dashboard/jobs_name", name="jobs_name", methods={"GET", "POST"})
     */
    public function jobsName(Request $request, ObjectManager $manager, PaginatorInterface $paginator)
    {
        $jobsName = $manager->getRepository(JobName::class)->findBy([], ['name' => 'asc']);
        $jobsNameNb = count($jobsName);

        $jobName = new JobName();
        $form = $this->createForm(JobNameType::class, $jobName);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($jobName);
            $manager->flush();

            $this->addFlash('success', 'Le métier a bien été ajouté !');

            return $this->redirectToRoute('jobs_name');
        }

        $pagination = $paginator->paginate(
            $jobsName,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('dashboard/jobs_name.html.twig', [
            'form' => $form->createView(),
            'jobsNameNb' => $jobsNameNb,
            'jobsName' => $pagination,
        ]);
    }

    /**
     * @Route("/job_name/delete/{id}", name="delete_job_name")
     */
    public function deleteJobName($id)
    {
        $em = $this->getDoctrine()->getManager();
        $jobNameToDelete = $em->getRepository(JobName::class)->find($id);

        $em->remove($jobNameToDelete);
        $em->flush();

        $this->addFlash('success', 'Métier supprimé avec succès !');

        return $this->redirectToRoute('jobs_name');
    }

    /**
     * @Route("/job_name/edit/{id}", name="jobs_name_edit")
     */
    public function editJobName(JobName $jobName, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $jobsName = $em->getRepository(JobName::class)->findBy([], ['name' => 'asc']);
        $jobsNameNb = count($jobsName);

        $form = $this->createForm(JobNameType::class, $jobName);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Métier modifié avec succès !');

            return $this->redirectToRoute('jobs_name');
        }

        return $this->render('dashboard/jobs_name_edit.html.twig', [
            'form' => $form->createView(),
            'jobsNameNb' => $jobsNameNb,
        ]);
    }
}
