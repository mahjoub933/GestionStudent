<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as Serializer;
/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 */
class Club
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $REF;

    /**
     * @ORM\Column(type="date")
     * @Assert\Range(
     *      min = "2019-01-14",
     *      max = "2019-04-14"
     * )
     * 
     * 
     * @Serializer\SerializedName("creationdate")
     * @Serializer\Expose()
     * 
     */
    private $creationdate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getREF(): ?string
    {
        return $this->REF;
    }

    public function setREF(string $REF): self
    {
        $this->REF = $REF;

        return $this;
    }

    public function getCreationdate(): ?\DateTimeInterface
    {
        return $this->creationdate;
    }

    public function setCreationdate(\DateTimeInterface $creationdate): self
    {
        $this->creationdate = $creationdate;

        return $this;
    }
}
