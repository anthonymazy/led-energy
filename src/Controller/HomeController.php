<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\ProductSearch;
use App\Form\ContactType;
use App\Form\ProductSearchType;
use App\Notification\ContactNotification;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * Affiche la page d'accueil du site
     *
     * @Route("/", name="home")
     *
     * @param CategoryRepository $categoryRepository
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepo, ProductRepository $productRepo)
    {
        $ProductForm = $this->createForm(ProductSearchType::class);

        $categories = $categoryRepo->findAll();
        $products = $productRepo->findLatest();

        return $this->render('index.html.twig', [
            'categories' =>$categories,
            'products' => $products,
            'product_form' => $ProductForm->createView()
        ]);
    }

    /**
     * Permet de traiter le formulaire de recherche
     *
     * @Route("/search-product", name="search-product")
     *
     * @param Request $request
     * @param ProductRepository $productRepo
     * @return Response
     */
    public function handleFormSearch(Request $request, ProductRepository $productRepo)
    {
        $ProductForm = $this->createForm(ProductSearchType::class);
        if ($request->isMethod('POST')) {
            $ProductForm->handleRequest($request);
            $string = $ProductForm['product']->getData();
        } else {
            throw $this->createNotFoundException('La page n\'existe pas ');
        }

        $products = $productRepo->searchProduct($string);

        return $this->render('search.html.twig', ['products' => $products, 'product_form' => $ProductForm->createView(), 'string' => $string]);
    }

    /**
     * Affiche le formulaire de contact
     *
     * @Route("/contact", name="contact")
     *
     * @param Request $request
     * @param ContactNotification $notification
     * @return Response
     */
    public function contact(Request $request, ContactNotification $notification)
    {
        $contact = new Contact();

        $ProductForm = $this->createForm(ProductSearchType::class);

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact);
            $this->addFlash('success', 'Votre email a bien été envoyé');
            return $this->redirectToRoute('home');
        }

        return $this->render('contact.html.twig', [
            'form' => $form->createView(),
            'product_form' => $ProductForm->createView()
        ]);
    }
}
