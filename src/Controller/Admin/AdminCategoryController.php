<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * Affiche la liste de toutes les catégories
     *
     * @Route("/admin/category", name="admin_category_index")
     *
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $cagegories = $categoryRepository->findAll();

        return $this->render('admin/category/index.html.twig', ['categories' => $cagegories]);
    }

    /**
     * Permet d'ajouter une catégorie
     *
     * @Route("/admin/category/create", name="admin_category_create")
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            $this->addFlash('success', 'La catégorie a bien été ajoutée');

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/category/form_add_edit.html.twig', [
            'form'    => $form->createView(),
            'message' => 'Ajouter'
        ]);
    }

    /**
     * Permet d'ajouter une catégorie
     *
     * @Route("/admin/category/update/{id}", name="admin_category_update")
     *
     * @param Category $category
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function update(Category $category, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'La catégorie a bien été modifiée');

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/category/form_add_edit.html.twig', [
            'form'    => $form->createView(),
            'message' => 'Modifier'
        ]);
    }

    /**
     * Permet de supprimer une categorie
     *
     * @Route("/admin/category/delete/{id}", name="admin_category_delete")
     *
     * @param Category $category
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Category $category, ObjectManager $manager)
    {
        $manager->remove($category);
        $manager->flush();

        $this->addFlash('success', 'La categorie a bien été supprimée');

        return $this->redirectToRoute('admin_category_index');
    }
}
