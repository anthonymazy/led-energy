<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setFirstName('Anthony')
            ->setLastName('Mazy')
            ->setEmail('anthonymazy@hotmail.fr')
            ->setHash($this->encoder->encodePassword($admin, 'password'));

        $manager->persist($admin);

//        for ($i = 1; $i <= 10; $i++) {
//            $category = new Category();
//            $category->setName("Catégorie n°$i");
//
//            $manager->persist($category);
//        }
//
//        for ($i = 1; $i <= 10; $i++) {
//            $product = new Product();
//            $product->setTitle('Keyboard');
//            $product->setPrice(19.99);
//            $product->setDescription('Ergonomic and stylish!');
//            $product->setIntroduction('Lorem');
//            $product->setCoverImage('https://picsum.photos/200/300');
//
//            // relates this product to the category
//            $product->setCategory($category);
//
//            $manager->persist($product);
//        }

        $manager->flush();
    }
}
