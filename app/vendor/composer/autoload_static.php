<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd4809cdd58b4f77504e93c30e2b7ee52
{
    public static $prefixLengthsPsr4 = array (
        'Y' => 
        array (
            'Yevgen87\\App\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Yevgen87\\App\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitd4809cdd58b4f77504e93c30e2b7ee52::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd4809cdd58b4f77504e93c30e2b7ee52::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd4809cdd58b4f77504e93c30e2b7ee52::$classMap;

        }, null, ClassLoader::class);
    }
}
