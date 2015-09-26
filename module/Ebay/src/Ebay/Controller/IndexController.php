<?php

namespace Ebay\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{
    protected $ebayFindingService;
    protected $session;
    protected $outputPath = './data/output/';

    /**
     * @param $ebayFindingService
     */
    public function __construct($ebayFindingService)
    {
        $this->ebayFindingService = $ebayFindingService;

        $this->session = new Container('token');
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();

            // validate token
            $token = $this->tokenValidate($data['token']);

            if ($token) {
                $results = $this->ebayFindingService->findItems($data);

                // save result as XML
                $xml = new \SimpleXMLElement('<?xml version="1.0"?><data></data>');
                $this->arrayToXml($results, $xml);
                $xml->asXML($this->outputPath . 'data.xml');
            }
        }

        return $this->redirect()->toRoute('get-started');
    }

    protected function arrayToXml($data, &$xmlData) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key) ){
                    $key = 'item' . $key; // dealing with <0/>..<n/> issues
                }

                $subnode = $xmlData->addChild($key);

                $this->arrayToXml($value, $subnode);
            } else {
                $xmlData->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }


    /**
     * @param $token
     *
     * @return bool
     */
    protected function tokenValidate($token) {
        $sessionToken = $this->session->offsetGet('token');

        if (!empty($token) && $token === $sessionToken) {
            return true;
        }

        return false;
    }
}
