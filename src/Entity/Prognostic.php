<?php

namespace App\Entity;

use App\Repository\PrognosticRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrognosticRepository::class)
 */
class Prognostic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $progDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $progType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $progBegin;

    /**
     * @ORM\Column(type="datetime")
     */
    private $progEnd;

    /**
     * @ORM\Column(type="float")
     */
    private $progSuccessChance;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProgDate(): ?\DateTimeInterface
    {
        return $this->progDate;
    }

    public function setProgDate(\DateTimeInterface $progDate): self
    {
        $this->progDate = $progDate;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getProgType(): ?string
    {
        return $this->progType;
    }

    public function setProgType(string $progType): self
    {
        $this->progType = $progType;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getProgBegin(): ?\DateTimeInterface
    {
        return $this->progBegin;
    }

    public function setProgBegin(\DateTimeInterface $progBegin): self
    {
        $this->progBegin = $progBegin;

        return $this;
    }

    public function getProgEnd(): ?\DateTimeInterface
    {
        return $this->progEnd;
    }

    public function setProgEnd(\DateTimeInterface $progEnd): self
    {
        $this->progEnd = $progEnd;

        return $this;
    }

    public function getProgSuccessChance(): ?float
    {
        return $this->progSuccessChance;
    }

    public function setProgSuccessChance(float $progSuccessChance): self
    {
        $this->progSuccessChance = $progSuccessChance;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
