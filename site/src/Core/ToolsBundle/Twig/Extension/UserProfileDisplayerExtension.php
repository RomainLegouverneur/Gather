<?php
 
namespace Core\ToolsBundle\Twig\Extension;
 
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Core\ToolsBundle\Helper\BaseHelper;
use Core\DatasBundle\Entity\User;

class UserProfileDisplayerExtension extends \Twig_Extension
{   
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
    
    public function getName()
    {
        return 'user_profile_displayer';
    }
    
    public function getFunctions()
    {
        return array(
            'displayUserProfileByEmail' => new \Twig_Function_Method($this, 'displayUserProfileByEmail', array('is_safe' => array('html'))),
            'displayUserProfile' => new \Twig_Function_Method($this, 'displayUserProfile', array('is_safe' => array('html'))), 
            );
    }
    
    public function displayUserProfile(User $target)
    {
        $access = BaseHelper::getAccessFromRequest($this->container->get('request'));
        $controllerName = ucwords($access) . '\MainBundle\Controller\ComponentsController';
        if (class_exists($controllerName))
        {
            $controller = new $controllerName();
            $controller->setContainer($this->container);
            if (method_exists($controller, 'displayUserPopoverAction'))
            {
                $user = $this->container->get('security.context')->getToken()->getUser();
                $rendering = $controller->displayUserPopoverAction($user, $target);
                $rendering = str_replace("\n", '', $rendering);
                $rendering = str_replace("\r", '', $rendering);
                $rendering = addslashes($rendering);
                return $this->container->get('templating')
                        ->render(
                                'CoreToolsBundle:TwigExtension:userProfileDisplayer.html.twig',
                                array('user' => $target, 'content' => $rendering, 'uniqid' => uniqid()),
                                null
                                );
            }
        }
    }
    
    public function displayUserProfileByEmail($email)
    {
        if (preg_match('#[a-zA-Z0-9-_\.]+@[a-zA-Z0-9-_\.]+\.[a-zA-Z]+#', $email, $res))
        {
            $mail = $res[0];
            if (($fromToUser = $this->container->get('doctrine')->getRepository('CoreDatasBundle:User')->findOneByEmail($mail)))
                return $this->displayUserProfile($fromToUser);
            return $mail;
        }
        return $email;
    }
}