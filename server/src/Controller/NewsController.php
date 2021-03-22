<?php

namespace App\Controller;

use App\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="create_news", methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function createNews(Request $request, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $news = new News();

        $news->setMessage($request->request->get('message'));
        $errors = $validator->validate($news);
        if(count($errors) > 0) {
            return new Response("BAD REQUEST", 400);
        }

        $entityManager->persist($news);
        $entityManager->flush();

        return new Response('Saved new news with id '.$news->getId());
    }

    /**
     * @Route("/news", name="list_news", methods={"GET"})
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function listNews(SerializerInterface $serializer): Response
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findAll();
        $json = $serializer->serialize(
            $news,
            'json'
        );
        return new Response($json);
    }

    /**
     * @Route("/news/{id}", name="delete_news", methods={"DELETE"})
     * @param News $news
     * @return Response
     */
    public function deleteNews(News $news): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($news);
        $entityManager->flush();

        return new Response('OK');
    }
}
