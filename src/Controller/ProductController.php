<?php

namespace App\Controller;

use App\Dto\SearchProduct;
use App\Entity\Product;
use App\Form\SearchProductType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {

        $this->entityManager = $entityManager;
    }

    #[Route('/nos-produits', name: 'app_products')]
    public function index(Request $request): Response
    {
        $searchProduct = new SearchProduct();
        $form = $this->createForm(SearchProductType::class, $searchProduct);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $products =  $this->entityManager->getRepository(Product::class)->findWithFilters($searchProduct);
        } else {
            $products = $this->entityManager->getRepository(Product::class)->findAll();
        }
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
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
