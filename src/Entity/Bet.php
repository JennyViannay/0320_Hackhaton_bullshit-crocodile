<?php

namespace App\Entity;

use App\Repository\BetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BetRepository::class)
 */
class Bet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $finish_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Excuse::class, inversedBy="bets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $excuse;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_archived;

    /**
     * @ORM\ManyToOne(targetEntity=ExcuseOfTheDay::class, inversedBy="bet")
     */
    private $excuseOfTheDay;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getFinishAt(): ?\DateTimeInterface
    {
        return $this->finish_at;
    }

    public function setFinishAt(\DateTimeInterface $finish_at): self
    {
        $this->finish_at = $finish_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getExcuse(): ?Excuse
    {
        return $this->excuse;
    }

    public function setExcuse(?Excuse $excuse): self
    {
        $this->excuse = $excuse;

        return $this;
    }

    public function getIsArchived(): ?bool
    {
        return $this->is_archived;
    }

    public function setIsArchived(bool $is_archived): self
    {
        $this->is_archived = $is_archived;

        return $this;
    }

    public function getExcuseOfTheDay(): ?ExcuseOfTheDay
    {
        return $this->excuseOfTheDay;
    }

    public function setExcuseOfTheDay(?ExcuseOfTheDay $excuseOfTheDay): self
    {
        $this->excuseOfTheDay = $excuseOfTheDay;

        return $this;
    }
}
