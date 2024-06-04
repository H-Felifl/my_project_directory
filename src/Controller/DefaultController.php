<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Product;
use App\Form\CategoryType;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//use App\Form\OrderType;

class DefaultController extends AbstractController

{

    #[Route('/home', name: 'app_categories')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categories=$entityManager->getRepository(Category::class)->findAll();

     return $this->render('default/index.html.twig',
            ['categories' => $categories]);
    }

    #[Route('/product/{id}', name: 'app_product')]
    public function index2(EntityManagerInterface $entityManager, $id): Response
    {
    $product=$entityManager->getRepository(Category::class)->find($id);
    //    dd($product);

    return $this->render('default/products.html.twig', ['product' => $product,]);
    }

    #[Route('/order/{id}', name: 'app_order')]
    public function order(EntityManagerInterface $entityManager, $id,Request $request): \Symfony\Component\HttpFoundation\RedirectResponse|Response
    {
        $order=new Order();
        $form=$this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        $product = $entityManager->getRepository(Product::class)->find($id);
        if($form->isSubmitted() && $form->isValid())
        {
            //afhandelen data
            $order = $form->getData();
            $product=$entityManager->getRepository(Product::class)->find($id);
            $order->setProduct($product);
            //dd($department);
            $entityManager->persist($order);
            $entityManager->flush();
            $this->addFlash('success','De order is toegevoegd');
            return $this->redirectToRoute('app_departments');
        }
        return $this->render('default/new.html.twig', [
            'form' => $form,
            'product' => $product
        ]);
    }

    #[\Symfony\Component\Routing\Attribute\Route('/new', name: 'app_new_category')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
//        $department=new Department();
        $form=$this->createForm(CategoryType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $category = $form->getData();
//            dd($department);
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success','De afdeling is toegevoegd');
            return $this->redirectToRoute('app_categories');
        }

        return $this->render('default/new.html.twig', [
            'form' => $form,
        ]);
    }













//    #[\Symfony\Component\Routing\Attribute\Route('/new', name: 'app_new_category')]
//    public function new(EntityManagerInterface $entityManager, Request $request): Response
//    {
//        $category=new Category();
//        $form=$this->createForm(CategoryType::class, $category);
//
//        $form->handleRequest($request);
//
//        if($form->isSubmitted() && $form->isValid())
//        {
//            $category = $form->getData();
//            //dd($department);
//            $entityManager->persist($category);
//            $entityManager->flush();
//            $this->addFlash('success','De categorie is toegevoegd!');
//            return $this->redirectToRoute('app_categories');
//        }
//
//        return $this->render('default/new.html.twig', [
//            'form' => $form,
//        ]);
//    }





}