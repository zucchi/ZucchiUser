<?php
/**
 * ZucchiUser (http://zucchi.co.uk/)
 *
 * @link      http://github.com/zucchi/ZucchiUser for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zucchi Limited (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */
namespace ZucchiUser;

use Zend\Mvc\MvcEvent;

use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\EventManager\EventInterface;
use ZucchiUser\Event\UserListener;
use Zucchi\Debug\Debug;

/**
 * Module to provide a standarised user
 * @author Matt Cockayne <matt@zucchi.co.uk>
 * @package ZucchiUser
 * @subpackage Module
 */
class Module implements 
    AutoloaderProviderInterface,
    ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        $listener = $sm->get('zucchiuser.listener');
        $listener->attach($em);
    }
    
    /**
     * (non-PHPdoc)
     * @see \Zend\ModuleManager\Feature\AutoloaderProviderInterface::getAutoloaderConfig()
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\ModuleManager\Feature\ConfigProviderInterface::getConfig()
     */
    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
