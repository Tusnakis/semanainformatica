<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PonenciaRepository")
 */
class Ponencia
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
    private $titulopo;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(
     *     value = 0,
     *     message = "El número mínimo de likes es 0"
     * )
     */
    private $likepo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoriaponencia")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoriaponencia;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulopo(): ?string
    {
        return $this->titulopo;
    }

    public function setTitulopo(string $titulopo): self
    {
        $this->titulopo = $titulopo;

        return $this;
    }

    public function getLikepo(): ?int
    {
        return $this->likepo;
    }

    public function setLikepo(int $likepo): self
    {
        $this->likepo = $likepo;

        return $this;
    }

    public function getCategoriaponencia(): ?Categoriaponencia
    {
        return $this->categoriaponencia;
    }

    public function setCategoriaponencia(?Categoriaponencia $categoriaponencia): self
    {
        $this->categoriaponencia = $categoriaponencia;

        return $this;
    }
}
