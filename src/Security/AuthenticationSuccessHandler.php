<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Service\MessageService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(private MessageService $messageService, private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $user = $token->getUser();
        $chooseMessageUrl = $this->urlGenerator->generate('choose-message', [], UrlGeneratorInterface::ABSOLUTE_URL);

        if (!($user instanceof User)) {
            return new RedirectResponse($chooseMessageUrl);
        }

        $twitterId = $user->getId();
        $message = $this->messageService->getMessageByTwitterId($twitterId);

        if ($message === null) {
            return new RedirectResponse($chooseMessageUrl);
        }

        $bodyReportUrl = $this->urlGenerator->generate(
            'body-report',
            [ 'twitterId' => $twitterId ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new RedirectResponse($bodyReportUrl);
    }
}
