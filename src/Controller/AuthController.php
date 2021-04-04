<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"GET"})
     */
    public function login(): Response
    {
        return new RedirectResponse('/');
    }

    /**
     * @Route("/login/callback", name="login:callback", methods={"GET"})
     */
    public function callback(): Response
    {
        return new Response('doot');
    }
}
