<?php

namespace ContainerX6yKIUT;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSecurity_AccessMapService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'security.access_map' shared service.
     *
     * @return \Symfony\Component\Security\Http\AccessMap
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/AccessMapInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/AccessMap.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/RequestMatcherInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/ChainRequestMatcher.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/RequestMatcher/PathRequestMatcher.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/RequestMatcher/MethodRequestMatcher.php';

        $container->privates['security.access_map'] = $instance = new \Symfony\Component\Security\Http\AccessMap();

        $a = new \Symfony\Component\HttpFoundation\RequestMatcher\MethodRequestMatcher([0 => 'GET']);

        $instance->add(new \Symfony\Component\HttpFoundation\ChainRequestMatcher([0 => new \Symfony\Component\HttpFoundation\RequestMatcher\PathRequestMatcher('^/api/(register|login|doc|doc.json)')]), [0 => 'PUBLIC_ACCESS'], NULL);
        $instance->add(new \Symfony\Component\HttpFoundation\ChainRequestMatcher([0 => $a, 1 => new \Symfony\Component\HttpFoundation\RequestMatcher\PathRequestMatcher('^/api/products')]), [0 => 'PUBLIC_ACCESS'], NULL);
        $instance->add(new \Symfony\Component\HttpFoundation\ChainRequestMatcher([0 => $a, 1 => new \Symfony\Component\HttpFoundation\RequestMatcher\PathRequestMatcher('^/api/products/\\d+$')]), [0 => 'PUBLIC_ACCESS'], NULL);
        $instance->add(new \Symfony\Component\HttpFoundation\ChainRequestMatcher([0 => ($container->privates['.security.request_matcher.AMZT15Y'] ??= new \Symfony\Component\HttpFoundation\RequestMatcher\PathRequestMatcher('^/api'))]), [0 => 'IS_AUTHENTICATED_FULLY'], NULL);

        return $instance;
    }
}