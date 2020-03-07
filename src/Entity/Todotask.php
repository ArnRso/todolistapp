<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TodotaskRepository")
 */
class Todotask
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci d'indiquer un nom pour cette tâche.")
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $completed;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Todolist", inversedBy="todotasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $todolist;

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

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getTodolist(): ?Todolist
    {
        return $this->todolist;
    }

    public function setTodolist(?Todolist $todolist): self
    {
        $this->todolist = $todolist;

        return $this;
    }
}
