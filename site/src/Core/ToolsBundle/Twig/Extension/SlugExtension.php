<?php
 
namespace Core\ToolsBundle\Twig\Extension;
 
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Core\ToolsBundle\Helper\SlugHelper;

class SlugExtension extends \Twig_Extension
{     
    public function getName()
    {
        return 'slug';
    }
    
    public function getFunctions()
    {
        return array(
            'slug' => new \Twig_Function_Method($this, 'slug', array('is_safe' => array('html'))),
        );
    }
    
    public function slug($string)
    {
        return SlugHelper::slug($string);
    }
}