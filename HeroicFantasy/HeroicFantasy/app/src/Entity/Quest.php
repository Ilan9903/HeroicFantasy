<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Quest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    private int $reward;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Choice(choices: ['available', 'assigned', 'completed'], message: 'Statut invalide.')]
    private string $status = 'available';

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    private int $experienceGained;

    #[ORM\OneToOne(targetEntity: Reward::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reward $rewardEntity = null;

    // ✅ Ajout de la relation avec Hero pour pouvoir assigner une quête à un héros
    #[ORM\ManyToOne(targetEntity: Hero::class, inversedBy: 'quests')]
    private ?Hero $hero = null;

    // ✅ Getters et Setters existants (non modifiés)
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getReward(): int
    {
        return $this->reward;
    }

    public function setReward(int $reward): self
    {
        $this->reward = $reward;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getExperienceGained(): int
    {
        return $this->experienceGained;
    }

    public function setExperienceGained(int $experienceGained): self
    {
        $this->experienceGained = $experienceGained;
        return $this;
    }

    public function getRewardEntity(): ?Reward
    {
        return $this->rewardEntity;
    }

    public function setRewardEntity(Reward $rewardEntity): self
    {
        $this->rewardEntity = $rewardEntity;
        return $this;
    }

    // ✅ Getter et Setter pour Hero
    public function getHero(): ?Hero
    {
        return $this->hero;
    }

    public function setHero(?Hero $hero): self
    {
        $this->hero = $hero;
        return $this;
    }

    // ✅ Ajout d'une méthode pour assigner une quête à un héros
    public function assignToHero(Hero $hero): self
    {
        if ($this->status !== 'available') {
            throw new \Exception("Cette quête ne peut pas être assignée.");
        }

        $this->hero = $hero;
        $this->status = 'assigned';

        return $this;
    }
}
