<?php

namespace App\Controller;

use App\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class GroupController extends AbstractController
{
    /**
     * @Route("/group", name="create_group", methods={"POST"})
     */
    public function create_group(Request $request, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $group = new Group();

        $group->setName($request->request->get('name'));

        $errors = $validator->validate($group);

        if(count($errors) > 0) {
            return new Response("BAD REQUEST", 400);
        }

        $entityManager->persist($group);
        $entityManager->flush();

        return $this->json([
            'message' => 'Success',
        ]);
    }

    /**
    * @Route("/group", name="list_groups", methods={"GET"})
    */
    public function listGroups(SerializerInterface $serializer): Response
    {
      $news = $this->getDoctrine()->getRepository(Group::class)->findAll();
      $json = $serializer->serialize(
          $news,
          'json'
      );
      return new Response($json);
    }

    /**
    * @Route("/group/{id}", name="join_group", methods={"PATCH"})
    */
    public function joinGroup(Group $group, SerializerInterface $serializer): Response
    {
      $entityManager = $this->getDoctrine()->getManager();

      $me = $this->getUser();
      $group->addUser($me);

      $entityManager->persist($group);
      $entityManager->flush();

      return $this->json([
        'message' => 'Success',
      ]);
    }
}
