<?php
/**
 * @author asmproger <asmproger@gmail.com>
 * @copyright (c) 2019, asmproger
 */

namespace App\Repository;

use App\Entity\Category;
use Doctrine\ORM\EntityRepository;

/**
 * Class CategoriesRepository
 * @author asmproger <asmproger@gmail.com>
 * @copyright (c) 2019, asmproger
 * @package App\Repository
 */
class CategoriesRepository extends EntityRepository
{

    /**
     *
     */
    public function getCategoriesTree()
    {
        $categories = $this->getAll();

        $tree = [];
        foreach ($categories as $category) {
            /** @var Category $category */
            if (! $category->getParent()) {
                $route = '/' . $category->getCode();
                if (! in_array($route, $tree)) {
                    $tree[$category->getId()] = [
                        'title' => $category->getTitle(),
                        'route' => $route,
                        'children' => [],
                    ];
                }
                if (count($category->getChildren())) {
                    $tree[$category->getId()]['children'] =
                        $this->collectChildren($category->getChildren(), $route);
                }
            }
        }

        return $tree;
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
                if (! in_array($route, $resultArray)) {
                    $resultArray[$item->getId()] = [
                        'title' => $item->getTitle(),
                        'route' => $route,
                        'children' => [],
                    ];
                }
                if (count($item->getChildren())) {
                    $resultArray[$item->getId()]['children'] =
                        $this->collectChildren($item->getChildren(), $route);
                }
            }
        }

        return $resultArray;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $qB = $this->createQueryBuilder('c')->orderBy('c.parent', 'ASC');
        $result = $qB->getQuery()->getResult();

        return $result;
    }

    /**
     * @param [] $codes
     * @return mixed
     */
    public function findAllByCodes($codes)
    {
        $qB = $this->createQueryBuilder('c')
            ->where('c.code in (:codes)')
            ->setParameter('codes', $codes);
        $result = $qB->getQuery()->getResult();

        return $result;

    }
}
