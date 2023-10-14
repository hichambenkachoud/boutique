<?php
/**
 * @author BEN KACHOUD Hicham <h.benkachoud.im@gmail.com>
 */

namespace App\Dto;


use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private RequestStack $requestStack;
    private EntityManagerInterface $entityManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    public function add(int $id): void
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function get()
    {
        return $this->requestStack->getSession()->get('cart');
    }

    public function getDetails(): array
    {
        $cartDetails = [];
        foreach ($this->get() as $id => $quantity) {
            $product = $this->entityManager->getRepository(Product::class)->find($id);
            if (!$product) {
                $this->delete($id);
                continue;
            }
            $cartDetails[] = [
                'product' => $product,
                'quantity' => $quantity,
            ];
        }

        return  $cartDetails;
    }

    public function remove()
    {
        $this->requestStack->getSession()->remove('cart');
    }

    public function delete(int $id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);

        unset($cart[$id]);
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function decrease(int $id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if (!empty($cart[$id]) && $cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }
}