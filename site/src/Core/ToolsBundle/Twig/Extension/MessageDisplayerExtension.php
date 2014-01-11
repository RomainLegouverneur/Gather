<?php
 
namespace Core\ToolsBundle\Twig\Extension;
 
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bridge\Twig\Extension\FormExtension;

class MessageDisplayerExtension extends \Twig_Extension
{   
    public function getName()
    {
        return 'message_displayer';
    }
    
    public function getFunctions()
    {
        return array(
            'messageDisplay' => new \Twig_Function_Method($this, 'messageDisplay', array('is_safe' => array('html'))),
        );
    }
    
    public function messageDisplay(array $message)
    {
        if ($message)
        {
            $html = '<div class="' . (($message['success'] == true) ? ('md_success') : ('md_error')) . '">' . $message['text'] . '</div>';
            return $html;
        }
        return (null);
    }
}
