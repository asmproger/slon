<?php
/**
 * @author asmproger <asmproger@gmail.com>
 * @copyright (c) 2019, asmproger
 */

namespace App\Menu;

use App\Entity\Category;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;

class MenuBuilder
{
    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var
     */
    protected $entityManager;

    /**
     * MenuBuilder constructor.
     * @param FactoryInterface       $factory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(FactoryInterface $factory, EntityManagerInterface $entityManager)
    {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(array $options)
    {
        /** @var CategoriesRepository $categoriesRepo */
        $categoriesRepo = $this->entityManager->getRepository(Category::class);
        $tree = $categoriesRepo->getCategoriesTree();

        $menu = $this->factory->createItem('root');
        foreach ($tree as $item) {
            $menuItem = $menu->addChild($item['title'], ['route' => $item['route']]);
            if (! empty($item['children'])) {
                $this->buildChildren($menuItem, $item['children']);
            }
        }

        return $menu;
    }

    /**
     * @param $rootElement
     * @param $children
     */
    protected function buildChildren($rootElement, $children)
    {
        foreach ($children as $item) {
            $menuItem = $rootElement->addChild($item['title'], ['route' => $item['route']]);
            if (! empty($item['children'])) {
                $this->buildChildren($menuItem, $item['children']);
            }
        }
    }
}
