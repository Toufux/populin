<?php

namespace ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EasySlugger\Utf8Slugger;

/**
 * Elect.
 *
 * @ORM\Table(
 *     name="elects",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="idx_id", columns={"id"})
 *     },
 *     indexes={
 *          @ORM\Index(name="idx_birth_date", columns={"birth_date"}),
 *          @ORM\Index(name="socio_professional_category", columns={"socio_professional_category"}),
 *          @ORM\Index(name="idx_first_name", columns={"first_name"}),
 *          @ORM\Index(name="idx_last_name", columns={"last_name"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\ElectRepository")
 */
class Elect
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=512, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1, nullable=false)
     */
    private $gender = 'M';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var SocioProfessionalCategory
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\SocioProfessionalCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="socio_professional_category", referencedColumnName="id")
     * })
     */
    private $socioProfessionalCategory;

    /**
     * @var ElectMandateXref[]|Collection
     * @ORM\OneToMany(targetEntity="ApiBundle\Entity\ElectMandateXref", mappedBy="elect")
     */
    private $mandates;

    /**
     * Elect constructor.
     *
     * @param string                    $firstName
     * @param string                    $lastName
     * @param string                    $sex
     * @param \DateTime                 $birthDate
     * @param SocioProfessionalCategory $socioProfessionalCategory
     */
    public function __construct(
        $firstName,
        $lastName,
        $gender,
        \DateTime $birthDate,
        SocioProfessionalCategory $socioProfessionalCategory = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->slug = Utf8Slugger::uniqueSlugify($this->firstName.'-'.$this->lastName);
        $this->gender = $gender;
        $this->birthDate = $birthDate;
        $this->socioProfessionalCategory = $socioProfessionalCategory;
        $this->mandates = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     *
     * @return $this
     */
    public function setBirthDate(\DateTime $birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return SocioProfessionalCategory
     */
    public function getSocioProfessionalCategory()
    {
        return $this->socioProfessionalCategory;
    }

    /**
     * @param SocioProfessionalCategory $socioProfessionalCategory
     *
     * @return $this
     */
    public function setSocioProfessionalCategory(SocioProfessionalCategory $socioProfessionalCategory)
    {
        $this->socioProfessionalCategory = $socioProfessionalCategory;

        return $this;
    }

    /**
     * @return ElectMandateXref[]|Collection
     */
    public function getMandates()
    {
        return $this->mandates;
    }

    /**
     * @param ElectMandateXref $mandate
     *
     * @return $this
     */
    public function addMandate(ElectMandateXref $mandate)
    {
        $this->mandates->add($mandate);

        return $this;
    }

    /**
     * @param ElectMandateXref $mandate
     *
     * @return $this
     */
    public function removeMandate(ElectMandateXref $mandate)
    {
        $this->mandates->removeElement($mandate);

        return $this;
    }
}
