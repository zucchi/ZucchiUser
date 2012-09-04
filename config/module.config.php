<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'zucchi-user-admin' => 'ZucchiUser\Controller\AdminController',
        ),
    ),
    'navigation' => array(
        'ZucchiAdmin' => array(
            'user' => array(
                'label' => _('User'),
                'route' => 'ZucchiAdmin/ZucchiUser',
                'action' => 'list',
            ),
        )
    ),
    // default route 
    'router' => array(
        'routes' => array(
            'ZucchiAdmin' => array(
                'child_routes' => array(
                    'ZucchiUserRest' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route' => '/user[/:id]',
                            'defaults' => array(
                                'controller' => 'zucchi-user-admin',
                                'action' => null,
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'ZucchiUser' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route' => '/user[/:action]',
                            'defaults' => array(
                                'controller' => 'zucchi-user-admin',
                                'action' => null,
                            ),
                            'constraints' => array(
                                'action'     => '(list|create|update|delete)',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    
                ),
            ),
        ),
    ),
    'translator' => array(
        'locale' => 'en_GB',
        'translation_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ZucchiUser' => __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'zucchiuser.service' => function($sm) {
                $service = new ZucchiUser\Service\User();
                $em = $sm->get('doctrine.entitymanager.orm_default');
                $service->setEntityManager($em);
                return $service;
            },
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'zucchiuser_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(realpath(__DIR__ . '/../src/ZucchiUser/Entity')),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'ZucchiUser\Entity' => 'zucchiuser_driver',
                )
            )
        )
    ),
);