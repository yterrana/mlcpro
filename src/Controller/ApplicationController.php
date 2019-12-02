<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Job;
use App\Form\ApplicationType;
use App\Model\UploadModel;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ApplicationController extends AbstractController
{
    /**
     * @Route("/spontaneous_application", name="application")
     */
    public function index(Request $request, UploadModel $uploadModel, ObjectManager $manager, TokenGeneratorInterface $tokenGenerator, \Swift_Mailer $mailer)
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $request->request->get('application');

            /** @var UploadedFile $cv */
            $cv = $form['cv']->getData();

            /** @var UploadedFile $vitalCard */
            $vitalCard = $form['vitalCard']->getData();

            /** @var UploadedFile $idCard */
            $idCard = $form['idCard']->getData();

            /** @var UploadedFile $medicalVisit */
            $medicalVisit = $form['medicalVisit']->getData();

            /** @var UploadedFile $licenses */
            $licenses = $form['licenses']->getData();

            /** @var UploadedFile $clearances */
            $clearances = $form['clearances']->getData();

            /** @var UploadedFile $securityFormation */
            $securityFormation = $form['securityFormation']->getData();

            /** @var UploadedFile $homeJustification */
            $homeJustification = $form['homeJustification']->getData();

            /** @var UploadedFile $rib */
            $rib = $form['rib']->getData();

            /** @var UploadedFile $drivingLicense */
            $drivingLicense = $form['drivingLicense']->getData();

            /** @var UploadedFile $grayCard */
            $grayCard = $form['grayCard']->getData();

            $data = $request->request->get('application');

            $token = $tokenGenerator->generateToken();
            $job = false;
            $uploadModel->create($post, $token, $job, $cv, $vitalCard, $idCard, $medicalVisit, $licenses, $clearances, $securityFormation, $homeJustification, $rib, $drivingLicense, $grayCard);

            if ($cv or $vitalCard or $idCard or $medicalVisit or $licenses or $clearances or $securityFormation or $homeJustification or $rib or $drivingLicense or $grayCard) {
                $rootPath = $this->getParameter('applications_directory').'/'.$token;
                $zip = new \ZipArchive();
                $createdZip = $this->getParameter('applications_directory').'/'.$token.'.zip';

                if ($zip->open($createdZip, \ZipArchive::CREATE) === TRUE) {

                    /** @var \SplFileInfo[] $files */
                    $files = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($rootPath),
                        \RecursiveIteratorIterator::LEAVES_ONLY
                    );

                    foreach ($files as $name => $file)
                    {
                        if (!$file->isDir())
                        {
                            $filePath = $file->getRealPath();
                            $relativePath = substr($filePath, strlen($rootPath) + 1);

                            $zip->addFile($filePath, $relativePath);
                        }
                    }
                }
                $zip->close();

                $filesToDelete = glob($rootPath.'/*');
                foreach($filesToDelete as $file){
                    if(is_file($file))
                        unlink($file);
                }

                rmdir($rootPath);

            }
            $createdZip = $this->getParameter('applications_directory').'/'.$token.'.zip';

            if (file_exists($createdZip)) {
                $message = (new \Swift_Message('Candidature spontanée'))
                    ->setFrom('yterrana@gmail.com')
                    ->setTo('yterrana@hotmail.fr')
                    ->attach(\Swift_Attachment::fromPath($createdZip))
                    ->setBody(
                        $this->renderView(
                            'Emails/index.html.twig',
                            [
                                'uploadedAt' => $application->getUploadedAt(),
                                'firstname' => $data['firstname'],
                                'lastname' => $data['lastname'],
                                'phone' => $data['phone'],
                                'email' => $data['email'],
                                'message' => $data['message'],
                            ]
                        ),
                        'text/html'
                    )
                ;
            }
            else {
                $message = (new \Swift_Message('Candidature spontanée'))
                    ->setFrom('yterrana@gmail.com')
                    ->setTo('yterrana@hotmail.fr')
                    ->setBody(
                        $this->renderView(
                            'Emails/index.html.twig',
                            [
                                'uploadedAt' => $application->getUploadedAt(),
                                'firstname' => $data['firstname'],
                                'lastname' => $data['lastname'],
                                'phone' => $data['phone'],
                                'email' => $data['email'],
                                'message' => $data['message'],
                            ]
                        ),
                        'text/html'
                    )
                ;
            }

            //$mailer->send($message);

            $this->addFlash('success', 'Votre candidature a bien été envoyée !');

            return $this->redirectToRoute('application');
        }

        return $this->render('application/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/application/{id}", name="application_id")
     */
    public function applicationId(Request $request, $id, UploadModel $uploadModel, ObjectManager $manager, TokenGeneratorInterface $tokenGenerator, \Swift_Mailer $mailer)
    {
        $job = $manager->getRepository(Job::class)->find($id);
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $request->request->get('application');

            /** @var UploadedFile $cv */
            $cv = $form['cv']->getData();

            /** @var UploadedFile $vitalCard */
            $vitalCard = $form['vitalCard']->getData();

            /** @var UploadedFile $idCard */
            $idCard = $form['idCard']->getData();

            /** @var UploadedFile $medicalVisit */
            $medicalVisit = $form['medicalVisit']->getData();

            /** @var UploadedFile $licenses */
            $licenses = $form['licenses']->getData();

            /** @var UploadedFile $clearances */
            $clearances = $form['clearances']->getData();

            /** @var UploadedFile $securityFormation */
            $securityFormation = $form['securityFormation']->getData();

            /** @var UploadedFile $homeJustification */
            $homeJustification = $form['homeJustification']->getData();

            /** @var UploadedFile $rib */
            $rib = $form['rib']->getData();

            /** @var UploadedFile $drivingLicense */
            $drivingLicense = $form['drivingLicense']->getData();

            /** @var UploadedFile $grayCard */
            $grayCard = $form['grayCard']->getData();

            $data = $request->request->get('application');

            $token = $tokenGenerator->generateToken();
            $applicationModel = $uploadModel->create($post, $token, $job, $cv, $vitalCard, $idCard, $medicalVisit, $licenses, $clearances, $securityFormation, $homeJustification, $rib, $drivingLicense, $grayCard);

            if ($cv or $vitalCard or $idCard or $medicalVisit or $licenses or $clearances or $securityFormation or $homeJustification or $rib or $drivingLicense or $grayCard) {
                $rootPath = $this->getParameter('applications_directory').'/'.$token;
                $zip = new \ZipArchive();
                $createdZip = $this->getParameter('applications_directory').'/'.$token.'.zip';

                if ($zip->open($createdZip, \ZipArchive::CREATE) === TRUE) {

                    /** @var \SplFileInfo[] $files */
                    $files = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($rootPath),
                        \RecursiveIteratorIterator::LEAVES_ONLY
                    );

                    foreach ($files as $name => $file)
                    {
                        if (!$file->isDir())
                        {
                            $filePath = $file->getRealPath();
                            $relativePath = substr($filePath, strlen($rootPath) + 1);

                            $zip->addFile($filePath, $relativePath);
                        }
                    }
                }
                $zip->close();

                $filesToDelete = glob($rootPath.'/*');
                foreach($filesToDelete as $file){
                    if(is_file($file))
                        unlink($file);
                }

                rmdir($rootPath);

            }
            $createdZip = $this->getParameter('applications_directory').'/'.$token.'.zip';
            if (file_exists($createdZip)) {
                $message = (new \Swift_Message('Candidature'))
                    ->setFrom('yterrana@gmail.com')
                    ->setTo('yterrana@hotmail.fr')
                    ->attach(\Swift_Attachment::fromPath($createdZip))
                    ->setBody(
                        $this->renderView(
                            'Emails/application_for.html.twig',
                            [
                                'appliedFor' => $applicationModel->getJob(),
                                'uploadedAt' => $application->getUploadedAt(),
                                'firstname' => $data['firstname'],
                                'lastname' => $data['lastname'],
                                'phone' => $data['phone'],
                                'email' => $data['email'],
                                'message' => $data['message'],
                            ]
                        ),
                        'text/html'
                    )
                ;
            }
            else {
                $message = (new \Swift_Message('Candidature'))
                    ->setFrom('yterrana@gmail.com')
                    ->setTo('yterrana@hotmail.fr')
                    ->setBody(
                        $this->renderView(
                            'Emails/application_for.html.twig',
                            [
                                'appliedFor' => $applicationModel->getJob(),
                                'uploadedAt' => $application->getUploadedAt(),
                                'firstname' => $data['firstname'],
                                'lastname' => $data['lastname'],
                                'phone' => $data['phone'],
                                'email' => $data['email'],
                                'message' => $data['message'],
                            ]
                        ),
                        'text/html'
                    )
                ;
            }

            //$mailer->send($message);

            $this->addFlash('success', 'Votre candidature a bien été envoyée !');

            return $this->redirectToRoute('application_id', ['id' => $id]);
        }

        return $this->render('application/job_apply.html.twig', [
            'form' => $form->createView(),
            'job' => $job,
        ]);
    }
}
