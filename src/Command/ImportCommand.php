<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\MessageService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     * @var string
     */
    protected static $defaultName = 'app:import';

    public function __construct(private MessageService $messageService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Import message assignments')
            ->addOption('clear', 'c', InputOption::VALUE_NONE, 'Clear the database before importing')
            ->addArgument('file', InputArgument::REQUIRED, 'The file to import')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument('file');

        if (!is_string($file) || !file_exists($file)) {
            $output->writeln('<error>Invalid file argument</error>');

            return self::FAILURE;
        }

        $fileContents = file_get_contents($file);

        if (!is_string($fileContents)) {
            $output->writeln('<error>Unable to read from file: ' . $file . '</error>');

            return self::FAILURE;
        }

        // todo switch this for a streaming parser e.g. https://github.com/salsify/jsonstreamingparser
        $json = json_decode($fileContents, true);

        if ($json === null) {
            $output->writeln(
                '<error>JSON decoding error: [' . json_last_error() . '] ' . json_last_error_msg() . '</error>'
            );

            return self::FAILURE;
        }

        if ($input->getOption('clear') === true) {
            $output->write('Clearing database...');
            $this->messageService->clear();
            $output->writeln(' <info>done</info>');
        }

        foreach ($json as $twitterId => $assignedMessage) {
            $required = [ 'n', 'p1', 'p2', 'p3' ];
            foreach ($required as $req) {
                if (!is_array($assignedMessage) || !array_key_exists($req, $assignedMessage)) {
                    $output->writeln(sprintf(
                        '<error>Invalid assigned message, could not find key %s, message: %s => %s</error>',
                        $req,
                        $twitterId,
                        var_export($assignedMessage, true),
                    ));

                    continue 2;
                }
            }

            $this->messageService->assignMessage(
                (string)$twitterId,
                $assignedMessage['n'],
                $assignedMessage['p1'],
                $assignedMessage['p2'],
                $assignedMessage['p3'],
            );
        }

        return self::SUCCESS;
    }
}
