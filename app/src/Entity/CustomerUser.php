<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CustomerUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"customer:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"customer:write"}, "swagger_definition_name"="Write"},
 *     collectionOperations={
 *          "get"   ={"security"="is_granted('ROLE_USER', object)"},
 *          "post"  ={"security"="is_granted('ROLE_USER', object)"}
 *     },
 *     itemOperations={
 *          "get"   ={"security"="is_granted('USER_READ', object)"},
 *          "put"   ={"security"="is_granted('USER_UPDATE', object)"},
 *          "patch" ={"security"="is_granted('USER_UPDATE', object)"},
 *          "delete"={"security"="is_granted('USER_DELETE', object)"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=CustomerUserRepository::class)
 * @ORM\EntityListeners({"App\Doctrine\CustomerUserListener"})
 */
class CustomerUser
{
    /**
     * L'identifiant unique de l'utilisateur
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"customer:read"})
     */
    private $id;

    /**
     * Le prénom de l'utilisateur
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"customer:read", "customer:write"})
     */
    private $firstname;

    /**
     * Le nom de famille de l'utilisateur
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"customer:read", "customer:write"})
     */
    private $lastname;

    /**
     * La date et l'heure de création de l'utilisateur
     *
     * @ORM\Column(type="datetime_immutable")
     *
     * @Groups({"customer:read"})
     */
    private $created_at;

    /**
     * La date et l'heure de la dernière modification de l'utilisateur
     *
     * @ORM\Column(type="datetime_immutable")
     *
     * @Groups({"customer:read"})
     */
    private $updated_at;

    /**
     * L'identifiant du Client lié à l'utilisateur
     *
     * @ORM\ManyToOne(targetEntity=Customer::class)
     * @Groups({"customer:read"})
     * @SerializedName("linked_customer")
     */
    private $customer;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
        $this->setUpdatedAt(new \DateTimeImmutable('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return $this
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return $this
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     * @return $this
     */
    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
