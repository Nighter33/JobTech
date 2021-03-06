<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use App\Service\NumberManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="le champ prénom ne doit pas être vide !")
     * @ORM\Column(type="string", length=45)
     * @Assert\Length(max=45, maxMessage="Le prénom ne doit pas dépasser {{ limit }} caractères")
     */
    private $surname;

    /**
     * @Assert\NotBlank(message="le champ prénom ne doit pas être vide !")
     * @ORM\Column(type="string", length=45)
     * @Assert\Length(max=45, maxMessage="Le Nom ne doit pas dépasser {{ limit }} caractères")
     */
    private $firstName;

    /**
     * @Assert\NotBlank(message="le champ Email ne doit pas être vide !")
     * @Assert\Email(message="Cette email n'est pas valide")
     * @ORM\Column(type="string", length=80, unique=true)
     * @Assert\Length(max=80, maxMessage="Le Nom ne doit pas dépasser {{ limit }} caractères")
     */
    private $email;

    /**
     * @Assert\NotBlank(message="le champ Poste ne doit pas être vide !")
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max=100, maxMessage="Le Nom ne doit pas dépasser {{ limit }} caractères")
     */
    private $job;

    /**
     * @Assert\NotBlank(message="le champ Numéro de téléphone ne doit pas être vide !")
     * @ORM\Column(type="string", length=20)
     * @Assert\Length(max=20, maxMessage="Le Numéro de téléphone ne doit pas dépasser {{ limit }} caractères")
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity=Gender::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $gender;

    /**
     * @ORM\OneToOne(targetEntity=Company::class, mappedBy="contact", cascade={"persist", "remove"})
     */
    private $company;


    public function __toString()
    {
        return $this->getSurname() . ' ' . $this->getFirstName();
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
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return $this
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getJob(): ?string
    {
        return $this->job;
    }

    /**
     * @param string $job
     * @return $this
     */
    public function setJob(string $job): self
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function getFormattedPhoneNumber(): ?string
    {
        return NumberManager::addPointToPhoneNumber($this->getPhoneNumber());
    }

    /**
     * @param string|null $phoneNumber
     * @return $this
     */
    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Gender|null
     */
    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    /**
     * @param Gender|null $gender
     * @return $this
     */
    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        // set (or unset) the owning side of the relation if necessary
        $newContact = null === $company ? null : $this;
        if ($company->getContact() !== $newContact) {
            $company->setContact($newContact);
        }

        return $this;
    }
}
