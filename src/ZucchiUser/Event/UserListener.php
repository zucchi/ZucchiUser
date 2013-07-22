<?php
/**
 * ZucchiSecurity (http://zucchi.co.uk/)
 *
 * @link      http://github.com/zucchi/ZucchiSecurity for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */
namespace ZucchiUser\Event;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\Console\Request as CliRequest;
use Zend\ServiceManager\ServiceManagerAwareInterface;

use ZucchiSecurity\Event\SecurityEvent;
use Zucchi\ServiceManager\ServiceManagerAwareTrait;
use Zucchi\Event\EventProviderTrait as EventProviderTrait;
use Zucchi\Debug\Debug;

/**
 * Attach security based controls to events
 * 
 * @author Matt Cockayne <matt@zucchi.co.uk>
 * @package ZucchiSecurity
 * @subpackage Event
 */
class UserListener  implements 
    ListenerAggregateInterface,
    ServiceManagerAwareInterface,
    EventManagerAwareInterface
{
    use EventProviderTrait;
    use ServiceManagerAwareTrait;
    
    /**
     * currently registered listeners
     * @var array
     */
    protected $listeners = array();
    
    /**
     * Attach listeners to events
     * @param SharedEventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $shared = $events->getSharedManager();
        $this->listeners = array(
            $shared->attach(
                'ZucchiSecurity', 
                SecurityEvent::EVENT_AUTH_POST, 
                array($this, 'addUserEvent')
            ),
            $shared->attach(
                'ZucchiSecurity',
                SecurityEvent::EVENT_AUTH_FAIL,
                array($this, 'addUserEvent')
            ),
            $shared->attach(
                'ZucchiUser\Controller\AdminController', 
                array('crud.create.form', 'crud.update.form'), 
                array($this, 'populateUserAdminFormValues')
            ),
        );
    }
    
    /**
     * remove listeners from events
     * @param EventManagerInterface $event
     */
    public function detach(EventManagerInterface $events)
    {
        array_walk($this->listeners, array($events,'detach'));
        $this->listeners = array();
    }
    
    public function addUserEvent(EventInterface $event)
    {
        $service = $event->getServiceManager()
                         ->get('zucchiuser.service');
        $service->addEvent($event->getTarget(), $event->getName());
    } 
    
    public function populateUserAdminFormValues($event)
    {
        $sm = $this->getServiceManager();
        $config = $sm->get('Config');
        $roles = $config['ZucchiSecurity']['permissions']['roles'];
        ksort($roles);
        $form = $event->getTarget();
        $element = $form->get('roles');
        $values = array();
        foreach ($roles AS $role => $spec) {
            $values[$role] = isset($spec['label']) ? $spec['label'] : $role; 
        }
        $element->setValueOptions($values);
    }
}