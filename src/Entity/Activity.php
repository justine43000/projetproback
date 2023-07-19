<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource()]
#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $extra = null;

    #[ORM\OneToMany(mappedBy: 'id_activity', targetEntity: Thematique::class)]
    private Collection $thematiques;

    #[ORM\ManyToMany(targetEntity: Soft::class, inversedBy: 'activities')]
    private Collection $id_soft;

    public function __construct()
    {
        $this->thematiques = new ArrayCollection();
        $this->id_soft = new ArrayCollection();
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

    public function isExtra(): ?bool
    {
        return $this->extra;
    }

    public function setExtra(bool $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * @return Collection<int, Thematique>
     */
    public function getThematiques(): Collection
    {
        return $this->thematiques;
    }

    public function addThematique(Thematique $thematique): self
    {
        if (!$this->thematiques->contains($thematique)) {
            $this->thematiques->add($thematique);
            $thematique->setIdActivity($this);
        }

        return $this;
    }

    public function removeThematique(Thematique $thematique): self
    {
        if ($this->thematiques->removeElement($thematique)) {
            // set the owning side to null (unless already changed)
            if ($thematique->getIdActivity() === $this) {
                $thematique->setIdActivity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Soft>
     */
    public function getIdSoft(): Collection
    {
        return $this->id_soft;
    }

    public function addIdSoft(Soft $idSoft): self
    {
        if (!$this->id_soft->contains($idSoft)) {
            $this->id_soft->add($idSoft);
        }

        return $this;
    }

    public function removeIdSoft(Soft $idSoft): self
    {
        $this->id_soft->removeElement($idSoft);

        return $this;
    }
}
