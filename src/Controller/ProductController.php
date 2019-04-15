<?php

namespace App\Controller;

use App\Form\ProductSearchType;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * Affiche tous les produits d'une catégorie
     *
     * @Route("/category/{slug}/{id}", name="show_category")
     *
     * @return Response
     */
    public function showCategory($id, CategoryRepository $categoryRepo)
    {
        $ProductForm = $this->createForm(ProductSearchType::class);

        $categories = $categoryRepo->findAll();
        $category = $categoryRepo->find($id);
        $products = $category->getProducts();

        return $this->render('product/index.html.twig', [
            'product_form' => $ProductForm->createView(),
            'categories' => $categories,
            'products' => $products,
            'category' => $category
        ]);
    }

    /**
     * Affiche un produit
     *
     * @Route("/product/{slug}/{id}", name="show_product")
     *
     * @return Response
     */
    public function showProduct(CategoryRepository $categoryRepo, Product $product)
    {
        $ProductForm = $this->createForm(ProductSearchType::class);

        $categories = $categoryRepo->findAll();

        return $this->render('product/show.html.twig', [
            'product_form' => $ProductForm->createView(),
            'categories' => $categories,
            'product' => $product
        ]);
    }
}
