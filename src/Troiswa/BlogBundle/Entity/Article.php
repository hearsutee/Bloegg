<?php

namespace Troiswa\BlogBundle\Entity;

//a rajouter pour pouvoir utiliser les contraintes de champs:
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\BlogBundle\Entity\ArticleRepository")
 */
class Article
{

    /**

     * @ORM\OneToMany(targetEntity="Troiswa\BlogBundle\Entity\Comments", mappedBy ="article")

     */
    private $comments;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     * @ORM\Column(name="artimage", type="text")
     */
    private $artimage;

    /**
     * @var string

     * @ORM\Column(name="auteur", type="text")
     */
    private $auteur;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */

    private $dateCreation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cover", type="boolean")
     */
    private $cover;

    /**
     *
     *@ORM\ManyToMany(targetEntity="Troiswa\BlogBundle\Entity\Category")
     *
     */
    private $category;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Article
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set cover
     *
     * @param boolean $cover
     * @return Article
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return boolean 
     */
    public function getCover()
    {
        return $this->cover;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add comments
     *
     * @param \Troiswa\BlogBundle\Entity\Comments $comments
     * @return Article
     */
    public function addComment(\Troiswa\BlogBundle\Entity\Comments $comments)
    {
        $this->comments[] = $comments;

//        on rajoute ca :
        $comments->setArticle($this);
//        ...

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Troiswa\BlogBundle\Entity\Comments $comments
     */
    public function removeComment(\Troiswa\BlogBundle\Entity\Comments $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     * @return Article
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Add category
     *
     * @param \Troiswa\BlogBundle\Entity\Category $category
     * @return Article
     */
    public function addCategory(\Troiswa\BlogBundle\Entity\Category $category)
    {
        $this->category[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Troiswa\BlogBundle\Entity\Category $category
     */
    public function removeCategory(\Troiswa\BlogBundle\Entity\Category $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set artimage
     *
     * @param string $artimage
     * @return Article
     */
    public function setArtimage($artimage)
    {
        $this->artimage = $artimage;

        return $this;
    }

    /**
     * Get artimage
     *
     * @return string 
     */
    public function getArtimage()
    {
        return $this->artimage;
    }
}
