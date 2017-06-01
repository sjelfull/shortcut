<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitee12f7fae9622942077d15089779d805
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'Hashids\\' => 8,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Hashids\\' => 
        array (
            0 => __DIR__ . '/..' . '/hashids/hashids/src',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitee12f7fae9622942077d15089779d805::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitee12f7fae9622942077d15089779d805::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}