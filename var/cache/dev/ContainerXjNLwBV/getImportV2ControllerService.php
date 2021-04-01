<?php

namespace ContainerXjNLwBV;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getImportV2ControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\ImportV2Controller' shared autowired service.
     *
     * @return \App\Controller\ImportV2Controller
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/ImportV2Controller.php';
        include_once \dirname(__DIR__, 4).'/src/Functions/File.php';

        $container->services['App\\Controller\\ImportV2Controller'] = $instance = new \App\Controller\ImportV2Controller(($container->services['doctrine.orm.default_entity_manager'] ?? $container->getDoctrine_Orm_DefaultEntityManagerService()), ($container->privates['App\\Functions\\File'] ?? ($container->privates['App\\Functions\\File'] = new \App\Functions\File())));

        $instance->setContainer(($container->privates['.service_locator.5nX7ca3'] ?? $container->load('get_ServiceLocator_5nX7ca3Service'))->withContext('App\\Controller\\ImportV2Controller', $container));

        return $instance;
    }
}
