<?php

namespace User;

error_reporting(E_ERROR | E_WARNING | E_PARSE);

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;

use User\Listener\UserListener;

class Module implements AutoloaderProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->attach(new UserListener());

        $protectedRoute = [
            'get-started',
            'settings',
            'settings/default',
        ];

        $em->attach(MvcEvent::EVENT_ROUTE, function ($e) use ($protectedRoute) {
            $auth = new AuthenticationService();
            $user = $auth->getIdentity();

            // if user
            if (null !== $user) {
                // add variable to layout
                $twig = $e->getApplication()->getServiceManager()->get('twigenvironment');
                $twig->addGlobal('user', true);
            } else {
                $matchRoute = $e->getApplication()->getMvcEvent()->getRouteMatch()->getMatchedRouteName();

                if (in_array($matchRoute, $protectedRoute)) {
                    $response = $e->getResponse();
                    $response->setStatusCode(302);

                    // redirect to login route
                    $response->getHeaders()->addHeaderLine('Location', '/user/login');
                    $e->stopPropagation();
                }
            }
        });
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
		            // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ],
            ],
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
