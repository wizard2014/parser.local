<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    protected $mapper;
    protected $cache;
    protected $options;

    /**
     * @param $mapper
     * @param $cache
     * @param $options
     */
    public function __construct($mapper, $cache, $options)
    {
        $this->mapper  = $mapper;
        $this->cache   = $cache;
        $this->options = $options;
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $region = $this->options->getRegion();

        if ($request->isXmlHttpRequest()) {
            return new JsonModel([
                'region' => $region,
            ]);
        }

        return new ViewModel();
    }
}
