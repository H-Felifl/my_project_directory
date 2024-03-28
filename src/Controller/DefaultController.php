<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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