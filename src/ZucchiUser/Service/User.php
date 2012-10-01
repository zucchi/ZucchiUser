<?php
namespace ZucchiUser\Service;

use ZucchiDoctrine\Service\AbstractService;
use Zend\EventManager\EventInterface;

use Zucchi\Debug\Debug;

use ZucchiUser\Entity\User as UserEntity;
use ZucchiUser\Entity\Event as UserEvent;

class User extends AbstractService
{
    protected $entityName = '\ZucchiUser\Entity\User';

    public function addEvent(UserEntity $entity, $action = null, $data = array())
    {
        $userEvent = new UserEvent();
        $userEvent->User = $entity;
        $userEvent->action = $action;
        $userEvent->data = array_merge($data, array(
            'server' => $_SERVER,
            'environment' => $_ENV,
        ));
        
        $this->getEntityManager()->persist($userEvent);
        $this->getEntityManager()->flush();
    }
}