<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit91484b20051f9a3fe460040ff95c776e
{
    public static $prefixLengthsPsr4 = array (
        'n' => 
        array (
            'nikitaglobal\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'nikitaglobal\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'nikitaglobal\\controllers\\Socket' => __DIR__ . '/../..' . '/src/controllers/Socket.php',
        'nikitaglobal\\controllers\\client\\Client' => __DIR__ . '/../..' . '/src/controllers/client/Client.php',
        'nikitaglobal\\controllers\\client\\Socket' => __DIR__ . '/../..' . '/src/controllers/client/Socket.php',
        'nikitaglobal\\controllers\\server\\Server' => __DIR__ . '/../..' . '/src/controllers/server/Server.php',
        'nikitaglobal\\controllers\\server\\Socket' => __DIR__ . '/../..' . '/src/controllers/server/Socket.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit91484b20051f9a3fe460040ff95c776e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit91484b20051f9a3fe460040ff95c776e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit91484b20051f9a3fe460040ff95c776e::$classMap;

        }, null, ClassLoader::class);
    }
}
