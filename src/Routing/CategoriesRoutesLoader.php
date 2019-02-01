<?php
/**
 * @author asmproger <asmproger@gmail.com>
 * @copyright (c) 2019, asmproger
 */

namespace App\Routing;


use App\Entity\Category;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class CategoriesRoutesLoader extends Loader
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var array
     */
    protected $urls;

    /**
     * CategoriesRoutesLoader constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->urls = [
            'categories' => [],
            'products' => [],
        ];
        $this->entityManager = $entityManager;

        $this->createArrayForRoutes();
    }

    /**
     * @param mixed $resource
     * @param null  $type
     * @return RouteCollection
     */
    public function load($resource, $type = null)
    {
        $routes = new RouteCollection();
        if (count($this->urls['categories'])) {
            foreach ($this->urls['categories'] as $category) {
                $defaults = [
                    '_controller' => 'App\Controller\MainController::category',
                ];
                $requirements = [];
                $route = new Route($category, $defaults, $requirements);
                $routes->add($category, $route);
            }
        }
        if (count($this->urls['products'])) {
            foreach ($this->urls['products'] as $product) {
                $defaults = [
                    '_controller' => 'App\Controller\MainController::product',
                ];
                $requirements = [];
                $route = new Route($product, $defaults, $requirements);
                $routes->add($product, $route);
            }
        }

        return $routes;
    }

    /**
     * @param mixed $resource
     * @param null  $type
     * @return bool
     */
    public function supports($resource, $type = null)
    {
        return $type === 'categories_routes_loader';
    }

    /**
     * @return array
     */
    protected function createArrayForRoutes()
    {
        /** @var CategoriesRepository $categoriesRepo */
        $categoriesRepo = $this->entityManager->getRepository(Category::class);
        $categories = $categoriesRepo->getAll();

        $routesArray = [];
        foreach ($categories as $category) {
            /** @var Category $category */
            if (! $category->getParent()) {
                $route = '/' . $category->getCode();
                if (! in_array($route, $this->urls['categories'])) {
                    $this->urls['categories'][] = $route;
                }
                if (count($category->getChildren())) {
                    $this->collectChildren($category->getChildren(), $route);
                }
            }
        }

        return $routesArray;
    }

    /**
     * @param $items
     * @param $parentRoute
     * @return array
     */
    protected function collectChildren($items, $parentRoute)
    {
        /**
         * @var Category $item
         */
        $resultArray = [];
        foreach ($items as $item) {
            if (! isset($resultArray[$item->getId()])) {
                $route = $parentRoute . '/' . $item->getCode();
                if (! in_array($route, $this->urls['categories'])) {
                    $this->urls['categories'][] = $route;
                }
                if (count($item->getChildren())) {
                    $this->collectChildren($item->getChildren(), $route);
                }
                if (count($item->getCategoryProducts())) {
                    $this->collectProducts($item, $route);
                }
            }
        }
    }

    /**
     * @param Category $category
     * @param          $parentRoute
     */
    protected function collectProducts($category, $parentRoute)
    {
        foreach ($category->getCategoryProducts() as $link) {
            $route = $parentRoute . '/' . $link->getProduct()->getCode();
            if (! in_array($route, $this->urls['products'])) {
                $this->urls['products'][] = $route;
            }
        }
    }
}