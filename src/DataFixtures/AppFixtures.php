<?php

namespace App\DataFixtures;

use App\Entity\CategoriesProducts;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // categories
        $categoryEl = new Category();
        $categoryEl->setCode('electronics');
        $categoryEl->setTitle('Электроника');
        $categoryEl->setDescription('Категория Электроника');

        $categoryCell = new Category();
        $categoryCell->setCode('phones');
        $categoryCell->setTitle('Мобильные телефоны');
        $categoryCell->setDescription('Смартфоны и кнопочные');

        $categorySp = new Category();
        $categorySp->setCode('spare_parts');
        $categorySp->setTitle('Запасные части');
        $categorySp->setDescription('Экраны, батарейки, кнопки, корпуса');

        $categoryApp = new Category();
        $categoryApp->setCode('appliances');
        $categoryApp->setTitle('Бытовая техника');
        $categoryApp->setDescription('Холодильники, пылесосы, и прочее');

        $categoryRef = new Category();
        $categoryRef->setCode('refrigerators');
        $categoryRef->setTitle('Холодильники');
        $categoryRef->setDescription('Холодильники стационарные, переносные, горизонтальные');


        $categoryEl->addChild($categoryCell);
        $categoryEl->addChild($categorySp);
        $categoryApp->addChild($categoryRef);


        // products
        $productIphone = new Product();
        $productIphone->setCode('iphone');
        $productIphone->setTitle('Мобильный телефон apple');
        $productIphone->setPrice(2000);
        // категория Электроника/Мобильные телефоны

        $productIphoneD = new Product();
        $productIphoneD->setCode('iphone-display');
        $productIphoneD->setTitle('Дисплей apple');
        $productIphoneD->setPrice(500);
        // категория Электроника/Запасные части

        $productRef = new Product();
        $productRef->setCode('ref_sam');
        $productRef->setTitle('Холодильник Samsung');
        $productRef->setPrice(10000);
        // категория Бытовая техника/Холодильники

        $productCard = new Product();
        $productCard->setCode('card1000');
        $productCard->setTitle('Подарочная карта 1000р');
        $productCard->setPrice(1000);
	    // категории Электроника/Мобильные телефоны и Бытовая техника/Холодильники


        // categories_products
        $link1 = new CategoriesProducts();
        $link1->setCategory($categoryCell);
        $link1->setProduct($productIphone);

        $link2 = new CategoriesProducts();
        $link2->setCategory($categorySp);
        $link2->setProduct($productIphoneD);

        $link3 = new CategoriesProducts();
        $link3->setCategory($categoryRef);
        $link3->setProduct($productRef);

        $link4 = new CategoriesProducts();
        $link4->setCategory($categoryCell);
        $link4->setProduct($productCard);

        $link5 = new CategoriesProducts();
        $link5->setCategory($categoryRef);
        $link5->setProduct($productCard);

        $manager->persist($categoryEl);
        $manager->persist($categoryApp);

        $manager->persist($productIphone);
        $manager->persist($productIphoneD);
        $manager->persist($productRef);
        $manager->persist($productCard);

        $manager->persist($link1);
        $manager->persist($link2);
        $manager->persist($link3);
        $manager->persist($link4);
        $manager->persist($link5);

        $manager->flush();
    }
}
