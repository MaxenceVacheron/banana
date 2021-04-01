<?php

namespace ContainerXjNLwBV;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getBananaTestImportCommandService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Command\BananaTestImportCommand' shared autowired service.
     *
     * @return \App\Command\BananaTestImportCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/src/Command/BananaTestImportCommand.php';

        $container->privates['App\\Command\\BananaTestImportCommand'] = $instance = new \App\Command\BananaTestImportCommand();

        $instance->setName('banana:test-import');

        return $instance;
    }
}
