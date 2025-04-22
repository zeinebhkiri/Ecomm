<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?utilisateur $utilisateur = null;

    /**
     * @var Collection<int, produit>
     */
    #[ORM\ManyToMany(targetEntity: produit::class)]
    private Collection $produit;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?produit $produitt = null;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, produit>
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(produit $produit): static
    {
        if (!$this->produit->contains($produit)) {
            $this->produit->add($produit);
        }

        return $this;
    }

    public function removeProduit(produit $produit): static
    {
        $this->produit->removeElement($produit);

        return $this;
    }

    public function getProduitt(): ?produit
    {
        return $this->produitt;
    }

    public function setProduitt(?produit $produitt): static
    {
        $this->produitt = $produitt;

        return $this;
    }
}
