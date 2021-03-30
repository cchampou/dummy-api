<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="me", methods={"GET"})
     */
    public function me(SerializerInterface $serializer): Response
    {
        $me = $this->getUser();
        $json = $serializer->serialize(
            $me,
            'json'
        );
        return new Response($json);
    }
}
