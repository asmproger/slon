<?php
/**
 * @author asmproger <asmproger@gmail.com>
 * @copyright (c) 2019, asmproger
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Category
 * @author asmproger <asmproger@gmail.com>
 * @copyright (c) 2019, asmproger
 * @package App\Entity
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Category
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent", cascade={"persist"})
     */
    protected $children;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children", cascade={"all"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $parent;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $code;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="CategoriesProducts", cascade={"all"}, orphanRemoval=true, mappedBy="category")
     */
    protected $categoryProducts;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->categoryProducts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param ArrayCollection $children
     */
    public function setChildren(ArrayCollection $children): void
    {
        $this->children = $children;
    }

    /**
     * @param Category $child
     */
    public function addChild(Category $child): void
    {
        if (! $this->children->contains($child)) {
            $this->children->add($child);

            $child->setParent($this);
        }
    }

    /**
     * @param Category $child
     */
    public function removeChild(Category $child): void
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);

            $child->setParent(null);
        }
    }

    /**
     * @return Category|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     */
    public function setParent(Category $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getCategoryProducts()
    {
        return $this->categoryProducts;
    }

    /**
     * @param ArrayCollection $categoryProducts
     */
    public function setCategoryProducts(ArrayCollection $categoryProducts): void
    {
        $this->categoryProducts = $categoryProducts;
    }

}