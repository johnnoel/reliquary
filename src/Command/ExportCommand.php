<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\MessageService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCommand extends Command
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var string
     */
    protected static $defaultName = 'app:export';

    public function __construct(private MessageService $messageService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Export the current list of assigned messages');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('{');
        foreach ($this->messageService->getAllAssignedMessages() as $twitterId => $messageJson) {
            $output->writeln(sprintf('"%s": %s,', $twitterId, $messageJson));
        }
        $output->writeln('}');

        return self::SUCCESS;
    }
}
