<?php

namespace ContainerX6yKIUT;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_HVZ1qrService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.hVZ1qr_' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.hVZ1qr_'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'App\\Controller\\ApiRegistrationController::registration' => ['privates', '.service_locator.Mhqdd2r', 'get_ServiceLocator_Mhqdd2rService', true],
            'App\\Controller\\UserController::updateUserInfo' => ['privates', '.service_locator.Mhqdd2r', 'get_ServiceLocator_Mhqdd2rService', true],
            'App\\Kernel::loadRoutes' => ['privates', '.service_locator.y4_Zrx.', 'get_ServiceLocator_Y4Zrx_Service', true],
            'App\\Kernel::registerContainerConfiguration' => ['privates', '.service_locator.y4_Zrx.', 'get_ServiceLocator_Y4Zrx_Service', true],
            'kernel::loadRoutes' => ['privates', '.service_locator.y4_Zrx.', 'get_ServiceLocator_Y4Zrx_Service', true],
            'kernel::registerContainerConfiguration' => ['privates', '.service_locator.y4_Zrx.', 'get_ServiceLocator_Y4Zrx_Service', true],
            'App\\Controller\\ApiRegistrationController:registration' => ['privates', '.service_locator.Mhqdd2r', 'get_ServiceLocator_Mhqdd2rService', true],
            'App\\Controller\\UserController:updateUserInfo' => ['privates', '.service_locator.Mhqdd2r', 'get_ServiceLocator_Mhqdd2rService', true],
            'kernel:loadRoutes' => ['privates', '.service_locator.y4_Zrx.', 'get_ServiceLocator_Y4Zrx_Service', true],
            'kernel:registerContainerConfiguration' => ['privates', '.service_locator.y4_Zrx.', 'get_ServiceLocator_Y4Zrx_Service', true],
        ], [
            'App\\Controller\\ApiRegistrationController::registration' => '?',
            'App\\Controller\\UserController::updateUserInfo' => '?',
            'App\\Kernel::loadRoutes' => '?',
            'App\\Kernel::registerContainerConfiguration' => '?',
            'kernel::loadRoutes' => '?',
            'kernel::registerContainerConfiguration' => '?',
            'App\\Controller\\ApiRegistrationController:registration' => '?',
            'App\\Controller\\UserController:updateUserInfo' => '?',
            'kernel:loadRoutes' => '?',
            'kernel:registerContainerConfiguration' => '?',
        ]);
    }
}