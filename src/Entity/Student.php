<?php

namespace App\Entity;

use App\Repository\ClassroomRepository;
;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *  @Assert\Positive
     *@Assert\Length(
     * min = 8,
     * max = 8,
     * minMessage = "The NSC must include at least {{ limit }} numbers",
     * maxMessage = "The NSC must include at most {{ limit }} nymbers"
     * )
     */
    private $NSC;

    /**
     * @ORM\Column(type="string", length=255)
     *   @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @Assert\NotBlank
     
     */
     
    private $Email;

    /**
     * @ORM\ManyToOne(targetEntity=Classroom::class, inversedBy="students")
     */
    private $idclass;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNSC(): ?int
    {
        return $this->NSC;
    }

    public function setNSC(int $NSC): self
    {
        $this->NSC = $NSC;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getIdclass(): ?Classroom
    {
        return $this->idclass;
    }

    public function setIdclass(?Classroom $idclass): self
    {
        $this->idclass = $idclass;

        return $this;
    }
}
