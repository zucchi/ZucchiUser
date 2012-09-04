<?php
/**
 * Zucchi (http://zucchi.co.uk/)
 *
 * @link      http://github.com/zucchi/ for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zucchi Limited (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

namespace ZucchiUser\Controller;

use ZucchiAdmin\Controller\AbstractAdminController;
use ZucchiAdmin\Crud\ControllerTrait as CrudControllerTrait;
use Zucchi\Debug\Debug;


class AdminController extends AbstractAdminController 
{
    use CrudControllerTrait;
    
    protected $label = 'User';
    
    protected $service = 'zucchiuser.service';
    
    protected $listFields = array(
        'identity' => 'Identity',
        'forename' => 'Forename',
        'surname' => 'Surname',
        'email' => 'Email Address',
        'locked' => 'Locked',
    );
    
}
