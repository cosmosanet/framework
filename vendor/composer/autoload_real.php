<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInita2cd53c26ccaf4a4373003732a60a20a
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInita2cd53c26ccaf4a4373003732a60a20a', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInita2cd53c26ccaf4a4373003732a60a20a', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInita2cd53c26ccaf4a4373003732a60a20a::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}