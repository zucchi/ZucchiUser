<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'zucchi-user-admin' => 'ZucchiUser\Controller\AdminController',
            'zucchi-user-console' => 'ZucchiUser\Controller\ConsoleController',
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
                                'module' => 'ZucchiUser',
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
                                'module' => 'ZucchiUser',
                                'controller' => 'zucchi-user-admin',
                                'action' => null,
                            ),
                            'constraints' => array(
                                'action'     => '(list|create|update|delete|export)',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    
                ),
            ),
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'zucchi-user-create' => array(
                    'options' => array(
                        'route' => 'user create [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'zucchi-user-console',
                            'action' => 'create',
                        ),
                    ),
                ),
                'zucchi-user-resetpassword' => array(
                    'options' => array(
                        'route' => 'user resetpassword [--verbose|-v] <username> <password>',
                        'defaults' => array(
                            'controller' => 'zucchi-user-console',
                            'action' => 'resetpassword',
                        ),
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
        'invokables' => array(
            'zucchiuser.listener' => 'ZucchiUser\Event\UserListener',
            'zucchiuser.service' => 'ZucchiUser\Service\User',
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
    'ZucchiSecurity' => array(
        'permissions' => array(
            'map' => array(
                'ZucchiUser' => array(
                    'list' => 'read',
                    'export' => 'read',
                ),
            ),
            'roles' => array(
                'user-manager' => array(
                    'label' => 'User Manager',
                    'parents'=>array('admin')
                ),
            ),
            'resources' => array(
                'route' =>array(
                    'ZucchiAdmin' => array(
                        'children' => array('ZucchiUser'),
                    )
                ),
                'module' => array(
                    'ZucchiUser',
                ),
            ),
            'rules' => array(
                array(
                    'role' => 'user-manager',
                    'resource' => array(
                        'route:ZucchiAdmin/ZucchiUser',
                        'module:ZucchiUser',
                    ),
                    'privileges' => array(
                        'view', 'create', 'update', 'delete', 'export',
                    ),
                ),
            )
        ),
    ),
);