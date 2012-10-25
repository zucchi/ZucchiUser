<?php
/**
 * ConsoleController.php - ConsoleController
 *
 * @link      http://github.com/zucchifor the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zucchi Limited (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */

namespace ZucchiUser\Controller;;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Console\Request as ConsoleRequest;
use ZucchiUser\Entity\User;

/**
 * ConsoleController - Class Description
 *
 * @author Matt Cockayne <matt@zucchi.co.uk>
 * @package
 * @subpackage
 * @category
 */
class ConsoleController extends AbstractActionController
{
    public function createAction()
    {
        $request = $this->getRequest();

        // Make sure that we are running in a console and the user has not tricked our
        // application into running this action from a public web server.
        if (!$request instanceof ConsoleRequest){
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $service = $this->getServiceLocator()->get('zucchiuser.service');
        $metaData = $service->getMetadata();
        $user = new User();

        $props = $metaData->getFieldNames();
        foreach($props as $prop) {
            $field = $metaData->getFieldMapping($prop);
            if (!$metaData->isNullable($prop)) {
                $type = $metaData->getTypeOfField($prop);
                switch ($type) {
                    case 'json_array':
                        echo $prop .' (' . $type . '): ';
                        $value = readline();
                        $user->{$prop} = json_decode($value);
                        break;
                    default:
                        echo $prop .' (' . $type . '): ';
                        $value = readline();
                        $user->{$prop} = $value;
                        break;
                }

            }
        }

        if ($service->save($user)) {
            echo 'Creating User "' . $user->identity ,'" succeeded' . PHP_EOL;
        } else {
            echo 'Creating User "' . $user->identity ,'" failed' . PHP_EOL;
        }
    }

    public function resetpasswordAction()
    {
        $request = $this->getRequest();

        // Make sure that we are running in a console and the user has not tricked our
        // application into running this action from a public web server.
        if (!$request instanceof ConsoleRequest){
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $username = $request->getParam('username');
        $password = $request->getParam('password');

        $service = $this->getServiceLocator()->get('zucchiuser.service');

        $users = $service->getList(array('identity' => $username));

        foreach ($users as $user) {
            $user->credential = $password;
            $service->save($user);
        }

    }
}
