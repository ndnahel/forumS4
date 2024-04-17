<?php

namespace App\Entity;

use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagsRepository::class)]
class Tags
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
	
	#[ORM\Column(type: 'string', length: 255)]
	private ?string $libelle = null;
	
	#[ORM\Column(type: 'string')]
	private ?string $color = null;
	
	#[ORM\ManyToMany(targetEntity: Message::class, mappedBy: 'tags', fetch: 'EAGER')]
	private Collection $messages;
	
	public function __construct() {
		$this->messages = new ArrayCollection();
	}

    public function getId(): ?int
    {
        return $this->id;
    }
	
	public function getLibelle(): ?string
	{
		return $this->libelle;
	}
	
	public function setLibelle(string $libelle): self
	{
		$this->libelle = $libelle;
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
	
	public function addMessage(Message $message): self
	{
		if (!$this->messages->contains($message)) {
			$this->messages[] = $message;
			$message->addTag($this);
		}
		return $this;
	}
}
