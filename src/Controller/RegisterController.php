<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $entityManager,  private readonly UserPasswordHasherInterface $hasher)
    {
    }

    #[Route('/register', name: 'app_register')]
    public function index(Request $request): Response
    {

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($request->isMethod(Request::METHOD_POST) && $form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $this->hasher->hashPassword($user, $user->getPassword())
            );
            $this->entityManager->persist($user);
            $this->entityManager->flush();
//            dd($user);
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
