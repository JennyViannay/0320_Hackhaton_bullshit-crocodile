<?php

namespace App\Entity;

use App\Repository\ExcuseOfTheDayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExcuseOfTheDayRepository::class)
 */
class ExcuseOfTheDay
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Excuse::class, inversedBy="excuseOfTheDays")
     */
    private $excuse;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=user::class, mappedBy="excuseOfTheDay")
     */
    private $winners;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="excuseOfTheDay")
     */
    private $bet;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\Column(type="datetime")
     */
    private $finish_at;

    public function __construct()
    {
        $this->winners = new ArrayCollection();
        $this->bet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|user[]
     */
    public function getWinners(): Collection
    {
        return $this->winners;
    }

    public function addWinner(user $winner): self
    {
        if (!$this->winners->contains($winner)) {
            $this->winners[] = $winner;
            $winner->setExcuseOfTheDay($this);
        }

        return $this;
    }

    public function removeWinner(user $winner): self
    {
        if ($this->winners->contains($winner)) {
            $this->winners->removeElement($winner);
            // set the owning side to null (unless already changed)
            if ($winner->getExcuseOfTheDay() === $this) {
                $winner->setExcuseOfTheDay(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bet[]
     */
    public function getBet(): Collection
    {
        return $this->bet;
    }

    public function addBet(Bet $bet): self
    {
        if (!$this->bet->contains($bet)) {
            $this->bet[] = $bet;
            $bet->setExcuseOfTheDay($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): self
    {
        if ($this->bet->contains($bet)) {
            $this->bet->removeElement($bet);
            // set the owning side to null (unless already changed)
            if ($bet->getExcuseOfTheDay() === $this) {
                $bet->setExcuseOfTheDay(null);
            }
        }

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

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
}
