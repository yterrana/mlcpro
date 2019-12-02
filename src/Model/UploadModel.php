<?php

namespace App\Model;

use App\Entity\Application;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UploadModel {
    protected $em;
    protected $kernel;
    protected $tokenGenerator;

    public function __construct(EntityManagerInterface $em, KernelInterface $kernel, TokenGeneratorInterface $tokenGenerator)
    {
        $this->em = $em;
        $this->kernel = $kernel;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function create($post, $token, $job, $cv, $vitalCard, $idCard, $medicalVisit, $licenses, $clearances, $securityFormation, $homeJustification, $rib, $drivingLicense, $grayCard) {
        $application = new Application();

        if ($cv or $vitalCard or $idCard or $medicalVisit or $licenses or $clearances or $securityFormation or $homeJustification or $rib or $drivingLicense or $grayCard) {
            mkdir($this->kernel->getContainer()->getParameter('applications_directory') . '/' . $token, 0777);
        }

        if ($cv) {
            $originalFilename = pathinfo($cv->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$cv->guessExtension();

            $cv->move($this->kernel->getContainer()->getParameter('applications_directory').'/'.$token, $newFilename);

            $application->setCv($newFilename);
        }

        if ($vitalCard) {
            $originalFilename = pathinfo($vitalCard->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$vitalCard->guessExtension();

            $vitalCard->move($this->kernel->getContainer()->getParameter('applications_directory').'/'.$token, $newFilename);

            $application->setVitalCard($newFilename);
        }

        if ($idCard) {
            $originalFilename = pathinfo($idCard->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$idCard->guessExtension();

            $idCard->move($this->kernel->getContainer()->getParameter('applications_directory').'/'.$token, $newFilename);

            $application->setVitalCard($newFilename);
        }

        if ($medicalVisit) {
            $originalFilename = pathinfo($medicalVisit->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$medicalVisit->guessExtension();

            $medicalVisit->move($this->kernel->getContainer()->getParameter('applications_directory').'/'.$token, $newFilename);

            $application->setVitalCard($newFilename);
        }

        if ($licenses) {
            $originalFilename = pathinfo($licenses->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$licenses->guessExtension();

            $licenses->move($this->kernel->getContainer()->getParameter('applications_directory').'/'.$token, $newFilename);

            $application->setVitalCard($newFilename);
        }

        if ($clearances) {
            $originalFilename = pathinfo($clearances->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$clearances->guessExtension();

            $clearances->move($this->kernel->getContainer()->getParameter('applications_directory').'/'.$token, $newFilename);

            $application->setVitalCard($newFilename);
        }

        if ($securityFormation) {
            $originalFilename = pathinfo($securityFormation->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$securityFormation->guessExtension();

            $securityFormation->move($this->kernel->getContainer()->getParameter('applications_directory').'/'.$token, $newFilename);

            $application->setVitalCard($newFilename);
        }

        if ($homeJustification) {
            $originalFilename = pathinfo($homeJustification->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$homeJustification->guessExtension();

            $homeJustification->move($this->kernel->getContainer()->getParameter('applications_directory').'/'.$token, $newFilename);

            $application->setVitalCard($newFilename);
        }

        if ($rib) {
            $originalFilename = pathinfo($rib->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$rib->guessExtension();

            $rib->move($this->kernel->getContainer()->getParameter('applications_directory').'/'.$token, $newFilename);

            $application->setVitalCard($newFilename);
        }

        if ($drivingLicense) {
            $originalFilename = pathinfo($drivingLicense->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$drivingLicense->guessExtension();

            $drivingLicense->move($this->kernel->getContainer()->getParameter('applications_directory').'/'.$token, $newFilename);

            $application->setVitalCard($newFilename);
        }

        if ($grayCard) {
            $originalFilename = pathinfo($grayCard->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$grayCard->guessExtension();

            $grayCard->move($this->kernel->getContainer()->getParameter('applications_directory').'/'.$token, $newFilename);

            $application->setVitalCard($newFilename);
        }

        if (isset($post['firstname'])) {
            $application->setFirstname($post['firstname']);
        }
        if (isset($post['lastname'])) {
            $application->setLastname($post['lastname']);
        }
        if (isset($post['email'])) {
            $application->setEmail($post['email']);
        }
        if (isset($post['phone'])) {
            $application->setPhone($post['phone']);
        }
        if (isset($post['message'])) {
            $application->setMessage($post['message']);
        }

        $application->setToken($token);
        if ($job != false) {
            $application->setJob($job);
            $application->setAppForJob(true);
        }
        else {
            $application->setAppForJob(false);
        }
        $this->em->persist($application);
        $this->em->flush();

        return $application;
    }
}