<?php
/**
 * @author asmproger <asmproger@gmail.com>
 * @copyright (c) 2019, asmproger
 */

namespace App\Controller;


use App\Entity\CategoriesProducts;
use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoriesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->render('main/index.html.twig', [
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function category(Request $request)
    {
        $path = $request->getPathInfo();
        $pathParams = explode('/', $path);
        $code = $pathParams[count($pathParams) - 1];

        $categoriesRepo = $this->getDoctrine()->getRepository(Category::class);

        /** @var Category $category */
        $category = $categoriesRepo->findOneBy([
            'code' => $code,
        ]);

        unset($pathParams[count($pathParams) - 1]);
        $crumbs = $this->getBreadCrumbsByPath($pathParams);

        $subs = $category->getChildren();
        $productsLinks = $category->getCategoryProducts();

        return $this->render('main/category.html.twig', [
            'category' => $category,
            'productsLinks' => $productsLinks,
            'subs' => $subs,
            'path' => $path,
            'crumbs' => array_reverse($crumbs),
        ]);
    }

    /**
     * @param          $array
     * @param Category $category
     */
    private function getCrumbs(&$array, $category)
    {
        $parent = $category->getParent();
        if ($parent) {
            $array[] = $parent;
            $this->getCrumbs($array, $parent);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function product(Request $request)
    {
        $path = $request->getPathInfo();
        $pathParams = explode('/', $path);
        $productCode = $pathParams[count($pathParams) - 1];

        $productsRepo = $this->getDoctrine()->getRepository(Product::class);

        unset($pathParams[count($pathParams) - 1]);
        $crumbs = $this->getBreadCrumbsByPath($pathParams);

        /** @var @var Product $product */
        $product = $productsRepo->findOneBy([
            'code' => $productCode,
        ]);

        return $this->render('main/product.html.twig', [
            'product' => $product,
            'path' => $path,
            'crumbs' => $crumbs,
        ]);
    }

    /**
     * @param $pathParams
     * @return  mixed
     */
    protected function getBreadCrumbsByPath($pathParams)
    {
        $categoriesRepo = $this->getDoctrine()->getRepository(Category::class);
        $categories = $categoriesRepo->findAllByCodes($pathParams);

        return $categories;
    }
}