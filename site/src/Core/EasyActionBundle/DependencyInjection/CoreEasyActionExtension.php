<?php

namespace Core\EasyActionBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CoreEasyActionExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $this->loadViewsConfigurations($configs, $container);
    }
    
    private function loadViewsConfigurations(array &$configs, ContainerBuilder &$container)
    {
        $bundlesViews = glob(__DIR__.'/../../../*/*Bundle/Resources/config/view.yml');
        $views = array();
        foreach ($bundlesViews as $view)
        {
           $result = Yaml::parse($view);
           preg_match('#(/|\\\)([a-zA-Z0-9]+)(/|\\\)([a-zA-Z0-9]+)(/|\\\)Resources(/|\\\)config(/|\\\)view.yml$#', realpath($view), $res);
           $bundleName = $res[2] . $res[4];
           $result = $this->checkViewConfiguration($result);
           $views[$bundleName] = $result;
        }
        $container->setParameter('core_easy_action.views', $views);
    }
    
    private function checkViewConfiguration(array $conf)
    {
        $options = array(
            array('name' => 'metas', 'verif_func' => 'is_array', 'default' => array()),
            array('name' => 'stylesheets', 'verif_func' => 'is_array', 'default' => array()),
            array('name' => 'javascripts', 'verif_func' => 'is_array', 'default' => array()),
            array('name' => 'title', 'verif_func' => 'is_string', 'default' => ''),
            array('name' => 'layout', 'verif_func' => 'is_string', 'default' => ''),
        );
        
        $res = NULL;
        foreach ($conf as $target => $fields)
        {
            foreach ($options as $opt)
            {
                if (!isset($fields[$opt['name']]) || !$opt['verif_func']($fields[$opt['name']]))
                    $fields[$opt['name']] = $opt['default'];
                $res[$target] = $fields;
            }
        }
        return ($res);
    }
}
