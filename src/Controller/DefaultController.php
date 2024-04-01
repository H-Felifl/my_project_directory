<?php

namespace App\Controller;

use App\Entity\Category;
//use App\Entity\Employee;
use App\Entity\Order;
use App\Entity\Product;
//use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        ]);
    }















//    public function order(EntityManagerInterface $entityManager, $id,Request $request): \Symfony\Component\HttpFoundation\RedirectResponse|Response
//    {
//        $order=new Order();
//        $form=$this->createForm(OrderType::class, $order);
//        $form->handleRequest($request);
//        if($form->isSubmitted() && $form->isValid())
//        {
//            //afhandelen data
//            $order = $form->getData();
//            $product=$entityManager->getRepository(Product::class)->find($id);
//            $order->setProduct($product);
////            dd($order);
//            $entityManager->persist($order);
//            $entityManager->flush();
//            $this->addFlash('success','De order is toegevoegd');
//            return $this->redirectToRoute('app_departments');
//        }
//        return $this->render('default/new.html.twig', [
//            'form' => $form,
//        ]);
//    }












//    #[Route("/home")]
//   public function homepage()
//    {
//        return new Response( "<h1>" . "eerste pagina" . "</h1>");
//    }
//
//    #[Route("/second")]
//    public  function welkom()
//    {
//        return new Response("tweede ");
//    }
//
//    #[Route("/third")]
//    public  function doei()
//    {
//        return new Response("Tot ziens! ");
//    }



}