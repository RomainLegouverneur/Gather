<?php
 
namespace Core\ToolsBundle\Twig\Extension;
 
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Core\ToolsBundle\Helper\DebugHelper;

class DebugExtension extends \Twig_Extension
{     
    public function getName()
    {
        return 'debug';
    }
    
    public function getFunctions()
    {
        return array(
            'varDump' => new \Twig_Function_Method($this, 'varDump', array('is_safe' => array('html'))),
        );
    }
    
    public function varDump($var)
    {
        DebugHelper::varDump($var);
        return null;
    }
}