<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $ticketCode;

    /**
     * @ORM\Column(type="integer")
     */
    private $scanTimestamp;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicketCode(): ?string
    {
        return $this->ticketCode;
    }

    public function setTicketCode(string $ticketCode): self
    {
        $this->ticketCode = $ticketCode;

        return $this;
    }

    public function getScanTimestamp(): ?int
    {
        return $this->scanTimestamp;
    }

    public function setScanTimestamp(int $scanTimestamp): self
    {
        $this->scanTimestamp = $scanTimestamp;

        return $this;
    }
}
