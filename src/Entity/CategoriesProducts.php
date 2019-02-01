<?php
/**
 * @author asmproger <asmproger@gmail.com>
 * @copyright (c) 2019, asmproger
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CategoriesProducts
 * @author asmproger <asmproger@gmail.com>
 * @copyright (c) 2019, asmproger
 * @package App\Entity
 *
 * @ORM\Table(name="categories_products")
 * @ORM\Entity()
 */
class CategoriesProducts
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="categoryProducts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $category;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productCategories")
     * @ORM\JoinColumn(name="proudct_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $product;

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
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product    $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

}