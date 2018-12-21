<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person", indexes={@ORM\Index(name="fk_person_share_group_idx", columns={"share_group_id"})})
 * @ORM\Entity
 */
class Person
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @param mixed $shareGroupId
     * @return Person
     */
    public function setShareGroupId($shareGroupId)
    {
        $this->shareGroupId = $shareGroupId;
        return $this;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     */
    private $lastname;

    /**
     * @var ShareGroup
     *
     * @ORM\ManyToOne(targetEntity="ShareGroup", inversedBy="person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="share_group_id", referencedColumnName="id")
     * })
     */
    private $shareGroup;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Expense", mappedBy="person")
     */
    private $expense;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Debt", mappedBy="person")
     */
    private $from;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Debt", mappedBy="person")
     */
    private $to;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getShareGroup(): ?ShareGroup
    {
        return $this->shareGroup;
    }

    public function setShareGroup(?ShareGroup $shareGroup): self
    {
        $this->shareGroup = $shareGroup;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getExpense(): ?Collection
    {
        return $this->expense;
    }

    /**
     * @param Collection $expense
     * @return Person
     */
    public function setExpense(Collection $expense): ?Person
    {
        $this->expense = $expense;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getFrom(): ?Collection
    {
        return $this->from;
    }

    /**
     * @param Collection $from
     * @return Person
     */
    public function setFrom(Collection $from): ?Person
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getTo(): ?Collection
    {
        return $this->to;
    }

    /**
     * @param Collection $to
     * @return Person
     */
    public function setTo(Collection $to): ?Person
    {
        $this->to = $to;
        return $this;
    }

    public function __toString()
    {
        return $this->getFirstname();
    }


}
