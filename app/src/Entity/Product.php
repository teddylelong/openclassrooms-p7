<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={
            "get"
 *     },
 *     itemOperations = {
            "get"
 *     }
 * )
 *
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * L'identifiant unique du produit
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Le nom du produit
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     message="Le nom du produit ne peut pas être vide"
     * )
     * @Assert\NotNull(
     *     message="Le nom du produit ne peut pas être null"
     * )
     * @Assert\Length(
     *     min=1,
     *     max=255,
     *     minMessage="Le nom doit contenir au moins {{ limit }} caratères",
     *     maxMessage="Le nom ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * La marque du produit
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     message="La marque du produit ne peut pas être vide"
     * )
     * @Assert\NotNull(
     *     message="La marque du produit ne peut pas être nulle"
     * )
     * @Assert\Length(
     *     min=1,
     *     max=255,
     *     minMessage="La marque doit contenir au moins {{ limit }} caratères",
     *     maxMessage="La marque ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    private $brand;

    /**
     * La description du produit
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank(
     *     message="La description du produit ne peut pas être vide"
     * )
     * @Assert\NotNull(
     *     message="La description du produit ne peut pas être nulle"
     * )
     */
    private $description;

    /**
     * Le prix du produit (valeur numérique)
     *
     * @ORM\Column(type="decimal", precision=7, scale=2)
     *
     * @Assert\NotBlank(
     *     message="Le prix du produit ne peut pas être vide"
     * )
     * @Assert\NotNull(
     *     message="Le prix du produit ne peut pas être nulle"
     * )
     * @Assert\Type(
     *     type="Numeric",
     *     message="Le prix doit être une valeur numérique"
     * )
     * @Assert\Range(
     *     min="1",
     *     max="9999999",
     *     minMessage="Le prix doit être au moins supérieur ou égal à 1",
     *     maxMessage="Le prix ne peut pas dépasser 9 999 999.99"
     * )
     */
    private $price;

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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
