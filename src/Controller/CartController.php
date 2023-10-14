<?php

namespace App\Controller;

use App\Dto\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct()
    {
    }

    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getDetails()
        ]);
    }

    #[Route(path: '/cart/add/{id}', name: 'app_add_cart')]
    public function add(int $id, Cart $cart)
    {
        $cart->add($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route(path: '/cart/remove', name: 'app_remove_cart')]
    public function remove(Cart $cart)
    {
        $cart->remove();
        return $this->redirectToRoute('app_products');
    }

    #[Route(path: '/cart/remove/{id}', name: 'app_delete_cart')]
    public function delete(Cart $cart, int $id)
    {
        $cart->delete($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route(path: '/cart/decrease/{id}', name: 'app_decrease_cart')]
    public function decrease(Cart $cart, int $id)
    {
        $cart->decrease($id);
        return $this->redirectToRoute('app_cart');
    }
}
