<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductController extends AbstractController
{
    /**
     * Affiche la liste des produits
     *
     * @Route("/admin/product", name="admin_product_index")
     *
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render('admin/product/index.html.twig', ['products' => $products]);
    }

    /**
     * Permet d'ajouter un nouveau produit
     *
     * @Route("/admin/product/create", name="admin_product_create")
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($product);
            $manager->flush();

            $this->addFlash('success', 'Le produit a bien été ajouté');

            return $this->redirectToRoute('admin_product_index');
        }

        return $this->render('admin/product/form_add_edit.html.twig', [
            'form' => $form->createView(),
            'message' => 'Ajouter'
        ]);
    }

    /**
     * Permet de modifier un produit
     *
     * @Route("/admin/product/update/{id}", name="admin_product_update")
     *
     * @param Product $product
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function update(Product $product, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'Le produit a bien été modifié');

            return $this->redirectToRoute('admin_product_index');
        }

        return $this->render('admin/product/form_add_edit.html.twig', [
            'form' => $form->createView(),
            'message' => 'Modifier'
        ]);
    }

    /**
     * Permet de supprimer un produit
     *
     * @Route("/admin/product/delete/{id}", name="admin_product_delete")
     *
     * @param Product $product
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Product $product, ObjectManager $manager)
    {
        $manager->remove($product);
        $manager->flush();

        $this->addFlash('success', 'Le produit a bien été supprimé');

        return $this->redirectToRoute('admin_product_index');
    }
}
