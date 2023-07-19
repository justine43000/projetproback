<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource()]
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $event_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $event_end = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Calendar $id_calendar = null;

    #[ORM\ManyToMany(targetEntity: Thematique::class, inversedBy: 'events')]
    private Collection $id_thematique;

    public function __construct()
    {
        $this->id_thematique = new ArrayCollection();
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

    public function getEventStart(): ?\DateTimeInterface
    {
        return $this->event_start;
    }

    public function setEventStart(\DateTimeInterface $event_start): self
    {
        $this->event_start = $event_start;

        return $this;
    }

    public function getEventEnd(): ?\DateTimeInterface
    {
        return $this->event_end;
    }

    public function setEventEnd(\DateTimeInterface $event_end): self
    {
        $this->event_end = $event_end;

        return $this;
    }

    public function getIdCalendar(): ?Calendar
    {
        return $this->id_calendar;
    }

    public function setIdCalendar(?Calendar $id_calendar): self
    {
        $this->id_calendar = $id_calendar;

        return $this;
    }

    /**
     * @return Collection<int, Thematique>
     */
    public function getIdThematique(): Collection
    {
        return $this->id_thematique;
    }

    public function addIdThematique(Thematique $idThematique): self
    {
        if (!$this->id_thematique->contains($idThematique)) {
            $this->id_thematique->add($idThematique);
        }

        return $this;
    }

    public function removeIdThematique(Thematique $idThematique): self
    {
        $this->id_thematique->removeElement($idThematique);

        return $this;
    }
}
