<?php

    namespace App\VendingMachine\Module\Item\Infrastructure\Command;

use App\VendingMachine\Module\Item\Application\SetupItemCommand;
use App\VendingMachine\Module\Item\Application\SetupItemCommandHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

final class SetupItem extends Command
{
    private $logger;
    private $handler;

    public function __construct(SetupItemCommandHandler $handler, LoggerInterface $logger)
    {
        parent::__construct();
        $this->handler = $handler;
        $this->logger = $logger;
    }

    protected function configure()
    {
        $this
            ->setName('vendingmachine:item:setup')
            ->setDescription('Setup Item of the VendingMachine')
            ->addArgument('itemId', InputArgument::REQUIRED, 'ItemId to setup')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the item')
            ->addArgument('numberItems', InputArgument::REQUIRED, 'Number of items in stock')
            ->addArgument('price', InputArgument::REQUIRED, 'Price of the item');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $error = false;

        try {
            $itemId = $input->getArgument('itemId');
            $name = $input->getArgument('name');
            $numberItems = $input->getArgument('numberItems');
            $price = $input->getArgument('price');
            $command = new SetupItemCommand($itemId, $name, $price, $numberItems);

            ($this->handler)($command);
            $output->writeln(sprintf('ItemId saved successfully'));
        } catch (Throwable $exception) {
            $error = true;
            $this->logger->error(
                sprintf('%s %s', $exception->getMessage(), $exception->getTraceAsString()),
                ['job' => $this->getName()]
            );
        }


        return $error ? 1 : 0;
    }
}
