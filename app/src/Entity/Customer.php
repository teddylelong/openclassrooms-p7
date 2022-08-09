<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @TODO: Security dans subresourceOperations ne fonctionne pas
 *
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"admin:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"admin:write"}, "swagger_definition_name"="Write"},
 *     collectionOperations={
 *     },
 *     itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_ADMIN', object)",
 *              "openapi_context"={
 *                  "summary"="(Réservé aux administrateurs) Retourne les informations d'un compte client et ses utilisateurs liés",
 *                  "description"="Retourne les informations d'un compte client et ses utilisateurs liés. **Vous devez être administrateur pour accéder à cette fonctionnalité.**."
 *              }
 *          },
 *     },
 *     subresourceOperations={
 *          "customers_users_get_subresource"={
 *              "method"="GET",
 *              "security"="is_granted('ROLE_ADMIN', object)",
 *              "openapi_context"={
 *                  "summary"="(Réservé aux administrateurs) Retourne tous les utilisateurs liés au compte client spécifié",
 *                  "description"="Retourne tous les utilisateurs liés au compte client spécifié. **Vous devez être administrateur pour accéder à cette fonctionnalité.**."
 *              }
 *          },
 *     }
 * )
 */
class Customer implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ApiProperty(security="is_granted('ROLE_ADMIN')")
     * @Groups({"admin:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Assert\NotNull(
     *     message="Le nom d'utilisateur ne peut pas être nul"
     * )
     * @Assert\NotBlank(
     *     message="Le nom d'utilisateur ne peut pas être vide"
     * )
     * @Assert\Length(
     *     min=1,
     *     max=180,
     *     minMessage="Le nom d'utilisateur doit contenir au moins {{ limit }} charactères",
     *     maxMessage="Le nom d'utilisateur ne peut pas contenir plus de {{ limit }} charactères"
     * )
     * @Groups({"admin:read"})
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Groups({"admin:read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     *
     * @Assert\NotNull(
     *     message="Le mot de passe ne peut pas être nul"
     * )
     * @Assert\NotBlank(
     *     message="Le mot de passe ne peut pas être vide"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customer:read", "admin:read"})
     *
     * @Assert\NotNull(
     *     message="La société ne peut pas être nulle"
     * )
     * @Assert\NotBlank(
     *     message="La société ne peut pas être vide"
     * )
     * @Assert\Length(
     *     min=1,
     *     max=255,
     *     minMessage="Le nom de la société doit contenir au moins {{ limit }} charactères",
     *     maxMessage="Le nom de la société ne peut pas contenir plus de {{ limit }} charactères"
     * )
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customer:read", "admin:read"})
     *
     * @Assert\NotNull(
     *     message="L'adresse ne peut pas être nulle"
     * )
     * @Assert\NotBlank(
     *     message="L'adresse ne peut pas être vide"
     * )
     * @Assert\Length(
     *     min=1,
     *     max=255,
     *     minMessage="L'adresse doit contenir au moins {{ limit }} charactères",
     *     maxMessage="L'adresse ne peut pas contenir plus de {{ limit }} charactères"
     * )
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customer:read", "admin:read"})
     *
     * @Assert\NotNull(
     *     message="Le code postal ne peut pas être nul"
     * )
     * @Assert\NotBlank(
     *     message="Le code postal ne peut pas être vide"
     * )
     * @Assert\Length(
     *     min=1,
     *     max=255,
     *     minMessage="Le code postal doit contenir au moins {{ limit }} charactères",
     *     maxMessage="Le code postal ne peut pas contenir plus de {{ limit }} charactères"
     * )
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customer:read", "admin:read"})
     *
     * @Assert\NotNull(
     *     message="La ville ne peut pas être nulle"
     * )
     * @Assert\NotBlank(
     *     message="La ville ne peut pas être vide"
     * )
     * @Assert\Length(
     *     min=1,
     *     max=255,
     *     minMessage="La ville doit contenir au moins {{ limit }} charactères",
     *     maxMessage="La ville ne peut pas contenir plus de {{ limit }} charactères"
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customer:read", "admin:read"})
     *
     * @Assert\NotNull(
     *     message="Le numéro de téléphone ne peut pas être nul"
     * )
     * @Assert\NotBlank(
     *     message="Le numéro de téléphone ne peut pas être vide"
     * )
     * @Assert\Length(
     *     min=1,
     *     max=255,
     *     minMessage="Le numéro de téléphone doit contenir au moins {{ limit }} charactères",
     *     maxMessage="Le numéro de téléphone ne peut pas contenir plus de {{ limit }} charactères"
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @SerializedName("createdAt")
     * @Groups({"admin:read"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @SerializedName("updatedAt")
     * @Groups({"admin:read"})
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=CustomerUser::class, mappedBy="customer", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @ApiSubresource()
     * @SerializedName("customer_users")
     * @Groups({"admin:read"})
     */
    private $customersUsers;

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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     * @return string
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     * @return string
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string $company
     * @return $this
     */
    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getZip(): ?string
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     * @return $this
     */
    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, CustomerUser>
     */
    public function getCustomersUsers(): Collection
    {
        return $this->customersUsers;
    }

    /**
     * @param CustomerUser $customerUser
     * @return $this
     */
    public function addCustomersUser(CustomerUser $customerUser): self
    {
        if (!$this->customersUsers->contains($customerUser)) {
            $this->customersUsers[] = $customerUser;
            $customerUser->setCustomer($this);
        }

        return $this;
    }

    /**
     * @param CustomerUser $customerUser
     * @return $this
     */
    public function removeCustomersUser(CustomerUser $customerUser): self
    {
        if ($this->customersUsers->removeElement($customerUser)) {
            // set the owning side to null (unless already changed)
            if ($customerUser->getCustomer() === $this) {
                $customerUser->setCustomer(null);
            }
        }

        return $this;
    }
}
