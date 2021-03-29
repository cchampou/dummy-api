<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SecurityController.php',
        ]);
    }

    /**
    * @Route("/signup", name="app_signup", methods={"POST"})
    */
    public function signup(Request $request, ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder): Response
    {
      $entityManager = $this->getDoctrine()->getManager();

      $user = new User();
      $user->setEmail($request->request->get('email'));
      $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
      $errors = $validator->validate($user);

      if(count($errors) > 0) {
          return new Response("BAD REQUEST", 400);
      }

      $entityManager->persist($user);
      $entityManager->flush();

      return $this->json([
        'message' => 'success'
      ]);
    }

    /**
    * @Route("/login", name="app_login", methods={"POST"})
    */
    public function login()
    {
    }

}
