<?php

namespace ContainerX6yKIUT;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiRegistrationControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\ApiRegistrationController' shared autowired service.
     *
     * @return \App\Controller\ApiRegistrationController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/ApiRegistrationController.php';

        $container->services['App\\Controller\\ApiRegistrationController'] = $instance = new \App\Controller\ApiRegistrationController(($container->services['doctrine.orm.default_entity_manager'] ?? $container->load('getDoctrine_Orm_DefaultEntityManagerService')), ($container->privates['App\\Service\\QueryHelper'] ?? $container->load('getQueryHelperService')), ($container->privates['App\\Service\\EntityUpsert'] ?? $container->load('getEntityUpsertService')));

        $instance->setContainer(($container->privates['.service_locator.CshazM0'] ?? $container->load('get_ServiceLocator_CshazM0Service'))->withContext('App\\Controller\\ApiRegistrationController', $container));

        return $instance;
    }
}
