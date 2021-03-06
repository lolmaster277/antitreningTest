<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8047f66293000c35209af0f76384e84f
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'CloudPayments\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'CloudPayments\\' => 
        array (
            0 => __DIR__ . '/..' . '/troytft/cloud-payments-client/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8047f66293000c35209af0f76384e84f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8047f66293000c35209af0f76384e84f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
