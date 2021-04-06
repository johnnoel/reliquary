<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Service\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends AbstractController
{
    public function __construct(private MessageService $messageService)
    {
    }

    #[Route('/', name: 'home', methods: [ 'GET' ])]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/{twitterId}', name: 'body-report', requirements: [ 'twitterId' => '\d+' ], methods: [ 'GET' ])]
    public function bodyReport(Message $message): Response
    {
        return $this->render('body-report.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route(
        '/choose-message.{_format}',
        name: 'choose-message',
        requirements: [ '_format' => '|json' ],
        defaults: [ '_format' => 'html' ],
        methods: [ 'GET', 'POST' ]
    )]
    public function chooseMessage(Request $request, UserInterface $user): Response
    {
        if (!($user instanceof User)) {
            throw new AccessDeniedHttpException();
        }

        if ($request->isMethod('POST')) {
            $part1 = $request->request->get('p1', '');
            $part2 = $request->request->get('p2', '');
            $part3 = $request->request->get('p3', '');

            if (!$this->messageService->isValidMessage($part1, $part2, $part3)) {
                throw new BadRequestHttpException(
                    'Invalid parameters provided: ' . implode(', ', [ $part1, $part2, $part3 ])
                );
            }

            if (!$this->messageService->isMessageAvailable($part1, $part2, $part3)) {
                throw new ConflictHttpException(
                    'Message ' . implode(', ', [ $part1, $part2, $part3 ]) . ' already taken'
                );
            }

            $this->messageService->assignMessage($user->getId(), $user->getUsername(), $part1, $part2, $part3);

            if ($request->getRequestFormat() === 'json') {
                return new Response('', Response::HTTP_CREATED);
            }

            return $this->redirectToRoute('body-report', [ 'twitterId' => $user->getId() ]);
        }

        $existingMessage = $this->messageService->getMessageByTwitterId($user->getId());

        return $this->render('choose.html.twig', [
            'message' => $existingMessage,
        ]);
    }

    #[Route('/is-message-available', name: 'is-message-available', methods: [ 'GET' ])]
    public function isMessageAvailable(Request $request): Response
    {
        $part1 = $request->query->get('p1', '');
        $part2 = $request->query->get('p2', '');
        $part3 = $request->query->get('p3', '');

        if (!$this->messageService->isValidMessage($part1, $part2, $part3)) {
            throw new BadRequestHttpException();
        }

        if (!$this->messageService->isMessageAvailable($part1, $part2, $part3)) {
            return new Response('', Response::HTTP_OK);
        }

        return new Response('', Response::HTTP_NOT_FOUND);
    }

    #[Route('/random', name: 'random', methods: [ 'GET' ])]
    public function random(): RedirectResponse
    {
        $twitterId = $this->messageService->getRandomTwitterId();

        if ($twitterId === null) {
            return $this->redirectToRoute('home', [], Response::HTTP_FOUND);
        }

        return $this->redirectToRoute('body-report', [ 'twitterId' => $twitterId ], Response::HTTP_FOUND);
    }
}
