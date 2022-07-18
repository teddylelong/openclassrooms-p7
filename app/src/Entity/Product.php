<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations = {"get"},
 *     attributes={"force_eager"=false}
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
     *     notInRangeMessage="Le prix du produit doit être compris entre 1,00 et 9 999 999,99"
     * )
     */
    private $price;

    /**
     * La date et l'heure de création du produit
     *
     * @ORM\Column(type="datetime_immutable")
     * @SerializedName("createdAt")
     */
    private $created_at;

    /**
     * La date et l'heure de la dernière modification du produit
     *
     * @ORM\Column(type="datetime_immutable")
     * @SerializedName("updatedAt")
     */
    private $updated_at;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
        $this->setUpdatedAt(new \DateTimeImmutable('now'));
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     * @return $this
     */
    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return $this
     */
    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTimeImmutable $updated_at
     * @return $this
     */
    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * @param \DateTimeImmutable $created_at
     * @return $this
     */
    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
