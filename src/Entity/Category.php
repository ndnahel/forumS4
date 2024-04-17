<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
	
	#[ORM\Column(type: 'string', length: 255)]
	private ?string $name = null;
	
	#[ORM\Column(type: 'integer')]
	private ?int $position = null;
	
	#[ORM\Column(type: 'string', length: 6)]
	private ?string $color = null;
	
	#[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'category')]
	private Collection $messages;
	
	public function __construct() {
		$this->messages = new ArrayCollection();
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
	
	public function getPosition(): ?int
	{
		return $this->position;
	}
	
	public function setPosition(int $position): self
	{
		$this->position = $position;
		return $this;
	}
	
	public function getColor(): ?string
	{
		return $this->color;
	}
	
	public function setColor(string $color): self
	{
		$this->color = $color;
		return $this;
	}
	
	public function getMessages(): Collection
	{
		return $this->messages;
	}
}
