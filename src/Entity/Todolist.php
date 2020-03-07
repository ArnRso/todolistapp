<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TodolistRepository")
 * @UniqueEntity("name", message="Une liste porte déjà ce nom")
 */
class Todolist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Merci d'indiquer un nom pour cette liste.")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Todotask", mappedBy="todolist")
     */
    private $todotasks;

    public function __construct()
    {
        $this->todotasks = new ArrayCollection();
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

    /**
     * @return Collection|Todotask[]
     */
    public function getTodotasks(): Collection
    {
        return $this->todotasks;
    }

    public function addTodotask(Todotask $todotask): self
    {
        if (!$this->todotasks->contains($todotask)) {
            $this->todotasks[] = $todotask;
            $todotask->setTodolist($this);
        }

        return $this;
    }

    public function removeTodotask(Todotask $todotask): self
    {
        if ($this->todotasks->contains($todotask)) {
            $this->todotasks->removeElement($todotask);
            // set the owning side to null (unless already changed)
            if ($todotask->getTodolist() === $this) {
                $todotask->setTodolist(null);
            }
        }

        return $this;
    }
}
