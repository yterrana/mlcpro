<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationRepository")
 */
class Application
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cv;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vitalCard;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idCard;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $medicalVisit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $licenses;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $clearances;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $securityFormation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $homeJustification;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rib;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $drivingLicense;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $grayCard;

    /**
     * @ORM\Column(type="datetime")
     */
    private $uploaded_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Job", inversedBy="applications")
     * @ORM\JoinColumn(nullable=true)
     */
    private $job;

    /**
     * @ORM\Column(type="boolean")
     */
    private $appForJob;

    public function __construct()
    {
        $this->uploaded_at = new \Datetime();
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getUploadedAt(): ?\DateTimeInterface
    {
        return $this->uploaded_at;
    }

    public function setUploadedAt(\DateTimeInterface $uploaded_at): self
    {
        $this->uploaded_at = $uploaded_at;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getVitalCard(): ?string
    {
        return $this->vitalCard;
    }

    public function setVitalCard(?string $vitalCard): self
    {
        $this->vitalCard = $vitalCard;

        return $this;
    }

    public function getIdCard(): ?string
    {
        return $this->idCard;
    }

    public function setIdCard(?string $idCard): self
    {
        $this->idCard = $idCard;

        return $this;
    }

    public function getMedicalVisit(): ?string
    {
        return $this->medicalVisit;
    }

    public function setMedicalVisit(?string $medicalVisit): self
    {
        $this->medicalVisit = $medicalVisit;

        return $this;
    }

    public function getLicenses(): ?string
    {
        return $this->licenses;
    }

    public function setLicenses(?string $licenses): self
    {
        $this->licenses = $licenses;

        return $this;
    }

    public function getClearances(): ?string
    {
        return $this->clearances;
    }

    public function setClearances(?string $clearances): self
    {
        $this->clearances = $clearances;

        return $this;
    }

    public function getSecurityFormation(): ?string
    {
        return $this->securityFormation;
    }

    public function setSecurityFormation(?string $securityFormation): self
    {
        $this->securityFormation = $securityFormation;

        return $this;
    }

    public function getHomeJustification(): ?string
    {
        return $this->homeJustification;
    }

    public function setHomeJustification(?string $homeJustification): self
    {
        $this->homeJustification = $homeJustification;

        return $this;
    }

    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function setRib(?string $rib): self
    {
        $this->rib = $rib;

        return $this;
    }

    public function getDrivingLicense(): ?string
    {
        return $this->drivingLicense;
    }

    public function setDrivingLicense(?string $drivingLicense): self
    {
        $this->drivingLicense = $drivingLicense;

        return $this;
    }

    public function getGrayCard(): ?string
    {
        return $this->grayCard;
    }

    public function setGrayCard(?string $grayCard): self
    {
        $this->grayCard = $grayCard;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getAppForJob(): ?bool
    {
        return $this->appForJob;
    }

    public function setAppForJob(bool $appForJob): self
    {
        $this->appForJob = $appForJob;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }
}
