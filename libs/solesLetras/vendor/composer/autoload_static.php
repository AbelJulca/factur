<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit75596059b2ddb0c7ba5eedbe444417f2
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Luecano\\NumeroALetras\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Luecano\\NumeroALetras\\' => 
        array (
            0 => __DIR__ . '/..' . '/luecano/numero-a-letras/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit75596059b2ddb0c7ba5eedbe444417f2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit75596059b2ddb0c7ba5eedbe444417f2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit75596059b2ddb0c7ba5eedbe444417f2::$classMap;

        }, null, ClassLoader::class);
    }
}