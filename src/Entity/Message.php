<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
	
	#[ORM\Column(type: 'string', length: 255)]
	private ?string $title = null;
	
	#[ORM\Column(type: 'text')]
	private ?string $message = null;
	
	#[ORM\ManyToOne(targetEntity: Category::class, fetch: 'EAGER', inversedBy: 'messages')]
	private ?Category $category = null;
	
	#[ORM\Column(type: 'datetime')]
	private ?\DateTimeInterface $createdAt = null;
	
	#[ORM\ManyToOne(targetEntity: User::class, fetch: 'EAGER', inversedBy: 'messages')]
	private ?User $author = null;
	
	#[ORM\ManyToMany(targetEntity: Tags::class, inversedBy: 'messages', fetch: 'EAGER')]
	private Collection $tags;
	
	public function __construct() {
		$this->tags = new ArrayCollection();
	}

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
	
	public function getMessage(): ?string
	{
		return $this->message;
	}
	
	public function setMessage(string $message): self
	{
		$this->message = $message;
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
	
	public function getAuthor(): ?User
	{
		return $this->author;
	}
	
	public function setAuthor(?User $author): self
	{
		$this->author = $author;
		return $this;
	}
	
	public function getCategory(): ?Category
	{
		return $this->category;
	}
	
	public function setCategory(?Category $category): self
	{
		$this->category = $category;
		return $this;
	}
	
	public function getTags(): Collection
	{
		return $this->tags;
	}
	
	public function addTag(Tags $tag): self
	{
		if (!$this->tags->contains($tag)) {
			$this->tags[] = $tag;
		}
		return $this;
	}
}
