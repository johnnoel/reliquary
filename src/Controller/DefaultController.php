<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/{twitterId}", name="body-report", methods={"GET"}, requirements={"twitterId": "\d+"})
     */
    public function bodyReport(Message $message): Response
    {
        return $this->render('body-report.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/choose-message", name="choose-message", methods={"GET","POST"})
     */
    public function chooseMessage(Request $request): Response
    {
        return $this->render('choose.html.twig');
    }
}
