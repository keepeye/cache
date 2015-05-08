Introduction
===============
This is a simple PHP cache library.

It supports diffrent drivers.

Basic usage
=======

1. Install through `composer`

        composer require keepeye/cache

2. just look:

        <?php
        include "vendor/autoload.php";
        //first you should make a instance of cacheManager
        $cacheManager = new Keepeye\Cache\Cache;
        //get a instance of driver through cacheManager with some options
        $cache = $cacheManager->getInstance(array(
            "dir" => __DIR__."/cache"
        ));
        //store an item in the cache for 600 seconds.
        $cache->put("k1","v1",600);
        //retrieve an item by key
        $cache->get("k1");//output "v1"
        //remove an item
        $cache->forget("k1");
        $cache->get("k1");//get null
        //remove all
        $cache->fush();


Advanced usage
===============

1. FileDriver

    This driver is based on the filesystem.It has options below:

        - **dir** where the cache files stored in.
        - **depth** cache dir depth,default 2

2. Other drivers

    Some other drivers will be supported in future,such as redis、mysql、sqlite etc.

Tests
=========
You should have phpunit installed.
Then enter the directory, execute：

    composer install
    phpunit

License
===========

This library is open-sourced software licensed under the [MIT license][1]

[1]:http://opensource.org/licenses/MIT
