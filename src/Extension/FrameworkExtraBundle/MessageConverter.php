<?php

declare(strict_types=1);

namespace App\Extension\FrameworkExtraBundle;

use App\Entity\Message;
use App\Service\MessageService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class MessageConverter implements ParamConverterInterface
{
    public function __construct(private MessageService $messageService)
    {
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $twitterId = $request->attributes->get('twitterId');
        $message = $this->messageService->getMessageByTwitterId($twitterId);

        if ($message === null) {
            return false;
        }

        $request->attributes->set($configuration->getName(), $message);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === Message::class;
    }
}
