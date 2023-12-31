<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5f7c8b43ae68904b4f69cfe9fae19e5a
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5f7c8b43ae68904b4f69cfe9fae19e5a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5f7c8b43ae68904b4f69cfe9fae19e5a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5f7c8b43ae68904b4f69cfe9fae19e5a::$classMap;

        }, null, ClassLoader::class);
    }
}
