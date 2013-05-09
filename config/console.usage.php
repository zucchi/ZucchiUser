<?php
/**
 * console.usage.php
 *
 * @link      http://github.com/zucchifor the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zucchi Limited (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 * @author Matt Cockayne <matt@zucchi.co.uk>
 */
return array(
    // Describe available commands
    'user create [--verbose|-v]'    => 'Create a new user',
    // Describe expected parameters
    array( '--verbose|-v',     '(optional) turn on verbose mode'        ),

    'user create [--verbose|-v]'    => 'Prompted User creation',

    'user resetpassword [--verbose|-v] username password'    => 'Reset password for a user',
    // Describe expected parameters
    array( '--verbose|-v',     '(optional) turn on verbose mode'        ),
    array( 'username',     '(required) the username'        ),
    array( 'password',     '(required) the password'        ),
);