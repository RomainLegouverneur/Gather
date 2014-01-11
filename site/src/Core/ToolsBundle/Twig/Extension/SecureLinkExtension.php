<?php
 
namespace Core\ToolsBundle\Twig\Extension;
 
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Core\ToolsBundle\Helper\SecureLinkHelper;

class SecureLinkExtension extends FormExtension
{
    private $urlGenerator;
    private $formFactory;
    
    public function __construct(UrlGeneratorInterface $urlGenerator, FormFactoryInterface $formFactory) 
    {
        $this->urlGenerator = $urlGenerator;
        $this->formFactory = $formFactory;
        parent::__construct(array("CoreToolsBundle:SecureLinkExtension:secure_form_layout.html.twig"));
    }
    
    public function getName()
    {
        return 'securelink';
    }
    
    public function getFunctions()
    {
        return array(
            'secureLink' => new \Twig_Function_Method($this, 'secureLink', array('is_safe' => array('html'))),
        );
    }
    
    public function secureLink($text, $route, array $params = array(), $confirm = NULL)
    {
        $formId = 'secureLink_' . uniqid();
        $link = $this->urlGenerator->generate($route, $params);
        $onClick = ($confirm)
            ? ('if (confirm(\'' . $confirm . '\')) { document.getElementById(\'' . $formId . '\').submit() } return false;')
            : ('document.getElementById(\'' . $formId . '\').submit(); return false;');
        
        $form = SecureLinkHelper::buildForm($this->formFactory)->createView();
        $htmlLink = '<a href="' . $link . '" onClick="' . $onClick .'">' . $text . '</a>';
        $form = '<form style="display: inline" id="' . $formId . '" method="POST" action="' . $link . '">' . $this->renderWidget($form) . '</form>';
        return ($htmlLink . $form);
    }
}