<?php

namespace App\VendingMachine\Module\Money\Infrastructure\Controller;


use App\VendingMachine\Module\Money\Application\InsertCoinsCommand;
use App\VendingMachine\Module\Money\Application\InsertCoinsCommandHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class InsertCoinsPostController
{
    private $handler;

    public function __construct(InsertCoinsCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request)
    {
        try {
            $coins = $request->get('coins');
            $command = new InsertCoinsCommand($coins);

            ($this->handler)($command);

            return new Response('Ok', 200);

        } catch (Throwable $ex) {
            die;
        }
    }
}