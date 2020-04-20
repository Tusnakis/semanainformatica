<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TallerRepository")
 */
class Taller
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $titulota;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(
     *     value = 0,
     *     message = "El número mínimo de likes es 0"
     * )
     */
    private $liketa;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoriataller")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoriataller;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulota(): ?string
    {
        return $this->titulota;
    }

    public function setTitulota(string $titulota): self
    {
        $this->titulota = $titulota;

        return $this;
    }

    public function getLiketa(): ?int
    {
        return $this->liketa;
    }

    public function setLiketa(int $liketa): self
    {
        $this->liketa = $liketa;

        return $this;
    }

    public function getCategoriataller(): ?Categoriataller
    {
        return $this->categoriataller;
    }

    public function setCategoriataller(?Categoriataller $categoriataller): self
    {
        $this->categoriataller = $categoriataller;

        return $this;
    }
}
