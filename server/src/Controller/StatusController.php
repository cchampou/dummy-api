<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends AbstractController {

    /**
     * @Route("/status", methods={"GET"})
     * @return Response
     */
    public function status(): Response
    {
        return new Response("OK");
    }

    /**
     * @Route("/php", methods={"GET"})
     * @return Response
     */
    public function php(): Response
    {
        phpinfo();
        return new Response();
    }
}
