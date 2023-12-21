<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $projectID = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $projectName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOfStart = null;

    #[ORM\Column(type: "integer")]
    private ?int $teamSize = null;


    public function getProjectName(): ?string
    {
        return $this->projectName;
    }

    public function setProjectName(string $projectName): static
    {
        $this->projectName = $projectName;

        return $this;
    }

    public function getDateOfStart(): ?\DateTimeInterface
    {
        return $this->dateOfStart;
    }

    public function setDateOfStart(\DateTimeInterface $dateOfStart): static
    {
        $this->dateOfStart = $dateOfStart;

        return $this;
    }

    public function getTeamSize(): ?int
    {
        return $this->teamSize;
    }

    public function setTeamSize(int $teamSize): static
    {
        $this->teamSize = $teamSize;

        return $this;
    }

    /**
     * Get the value of projectID
     */
    public function getProjectID()
    {
        return $this->projectID;
    }
}
