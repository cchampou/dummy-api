<?php

namespace App\Controller;

use App\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="create_news", methods={"POST"})
     * @return Response
     */
    public function createNews(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $news = new News();
        $news->setMessage('Development has started');

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
}
