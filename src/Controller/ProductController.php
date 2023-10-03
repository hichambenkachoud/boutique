<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {

        $this->entityManager = $entityManager;
    }

    #[Route('/nos-produits', name: 'app_products')]
    public function index(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route(path: '/produits/{slug}', name: 'app_products_details')]
    public function details(Product $product): Response
    {
        return $this->render('product/details.html.twig', [
            'product' => $product
        ]);
    }
}
