<?php

namespace App\Entity;

use App\Repository\SlotRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity(repositoryClass=SlotRepository::class)
 */
class Slot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $slot_date;

    /**
     * @ORM\Column(type="time")
     */
    private $slot_time;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $booked;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlotDate(): ?\DateTimeInterface
    {
        return $this->slot_date;
    }

    public function setSlotDate(\DateTimeInterface $slot_date): self
    {
        $this->slot_date = $slot_date;

        return $this;
    }

    public function getSlotTime(): ?\DateTimeInterface
    {
        return $this->slot_time;
    }

    public function setSlotTime(\DateTimeInterface $slot_time): self
    {
        $this->slot_time = $slot_time;

        return $this;
    }

    public function getBooked(): ?string
    {
        return $this->booked;
    }

    public function setBooked(string $booked): self
    {
        $this->booked = $booked;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

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
}
