<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Ebay\Service\FindItemsService;

class ListenerController extends AbstractActionController
{
    /**
     * @var FindItemsService
     */
    protected $findItemsService;

    /**
     * ListenerController constructor.
     *
     * @param FindItemsService $findItemsService
     */
    public function __construct(FindItemsService  $findItemsService)
    {
        $this->findItemsService  = $findItemsService;
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $this->findItemsService->listen();
    }
}
