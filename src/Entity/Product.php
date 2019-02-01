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
 * Class Product
 * @author asmproger <asmproger@gmail.com>
 * @copyright (c) 2019, asmproger
 * @package App\Entity
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 */
class Product
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @var double
     * @ORM\Column(type="decimal", nullable=true)
     */
    protected $price = 0;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="CategoriesProducts", cascade={"all"}, orphanRemoval=true, mappedBy="product")
     */
    protected $productCategories;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->productCategories = new ArrayCollection();
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
    public function getDescription(): ?string
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
    public function getProductCategories()
    {
        return $this->productCategories;
    }

    /**
     * @param ArrayCollection $productCategories
     */
    public function setProductCategories(ArrayCollection $productCategories): void
    {
        $this->productCategories = $productCategories;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

}