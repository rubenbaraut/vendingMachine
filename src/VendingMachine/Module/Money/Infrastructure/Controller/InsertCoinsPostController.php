<?php

namespace App\VendingMachine\Module\Money\Infrastructure\Controller;

use App\VendingMachine\Module\Money\Application\InsertCoinsCommand;
use App\VendingMachine\Module\Money\Application\InsertCoinsCommandHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class InsertCoinsPostController
{
    private $handler;
    private $logger;

    public function __construct(InsertCoinsCommandHandler $handler, LoggerInterface $logger)
    {
        $this->handler = $handler;
        $this->logger = $logger;
    }

    public function __invoke(Request $request)
    {
        try {
            $coins = $request->get('coins');
            $command = new InsertCoinsCommand($coins);

            ($this->handler)($command);

            return new Response('Ok', 200);

        } catch (Throwable $ex) {
            $this->logger->error(sprintf('%s %s', $ex->getMessage(), $ex->getTraceAsString()));
        }
    }
}