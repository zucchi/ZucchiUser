**ZucchiUser**

Module to provide User Entity with management interface for Zucchi ZF2 Modules

*Installation*

From the root of your ZF2 Skeleton Application run

    ./composer.phar require zucchi/user
    
This module will require your vhost to use an AliasMatch

    AliasMatch /_([^/]+)/(.+)/([^/]+) /path/to/vendor/$2/public/$1/$3