<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobNameRepository")
 */
class JobName
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Job", mappedBy="title", cascade={"remove"})
     */
    private $jobNames;

    public function __construct()
    {
        $this->jobNames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Job[]
     */
    public function getJobNames(): Collection
    {
        return $this->jobNames;
    }

    public function addJobName(Job $jobName): self
    {
        if (!$this->jobNames->contains($jobName)) {
            $this->jobNames[] = $jobName;
            $jobName->setTitle($this);
        }

        return $this;
    }

    public function removeJobName(Job $jobName): self
    {
        if ($this->jobNames->contains($jobName)) {
            $this->jobNames->removeElement($jobName);
            // set the owning side to null (unless already changed)
            if ($jobName->getTitle() === $this) {
                $jobName->setTitle(null);
            }
        }

        return $this;
    }
}
