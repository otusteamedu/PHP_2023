<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb469704b3cc13e96fa0c8ce43c627116
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Builov\\Cinema\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Builov\\Cinema\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitb469704b3cc13e96fa0c8ce43c627116::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb469704b3cc13e96fa0c8ce43c627116::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb469704b3cc13e96fa0c8ce43c627116::$classMap;

        }, null, ClassLoader::class);
    }
}
