<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Animal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", length=14)
     *  @Assert\Length(
     *  min = 14, 
     *  max = 14, 
     * )
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(message = "Le champ nom n'est pas valide")
     */
    private $nom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $dateArrivee

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDepart

    /**
     * @ORM\Column(type="boolean")
     */
    private $proprietaire

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $genre

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $espece

    /**
     * @ORM\Column(type="string")
     */
    private $sexe

    /**
     * @ORM\Column(type="boolean")
     */
    private $steril

    /**
     * @ORM\Column(type="string")
     */
    private $quarantaine

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chaton", mappedBy="categorie", orphanRemoval=true)
     */
    private $chatons;

    eturn $this;
    }
}
