<?php

namespace Core\EasyActionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Core\ToolsBundle\Helper\SlugHelper;
use Core\ToolsBundle\Helper\HostHelper;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Core\ToolsBundle\Helper\DebugHelper;
//use Core\ToolsBundle\Helper\SecureLinkHelper;

abstract class EasyActionController extends Controller
{
    private             $refClass;
    private             $actionName;
    protected           $template;
    protected           $layout;
    
    public function     __construct()
    {
        $this->refClass = new \ReflectionClass(get_class($this));
    }
    
    public function  getUser()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if (!is_object($user))
            return NULL;
        return $user;
    }
	
    public function     actionCaller()
    {
        $args = func_get_args();
        if (method_exists($this, $this->actionName))
        {
            if (($response = $this->preActionControl()))
               return ($response);
            $this->template = $this->getTemplate();
            //$this->layout = $this->getBaseLayout();
            $method = $this->refClass->getMethod($this->actionName);
            if (($response = $method->invokeArgs($this, $args)))
               return ($response);
            $vars = get_object_vars($this);
            $vars['_user'] = $this->getUser();
            return $this->container->get('templating')->renderResponse(
                    'CoreEasyActionBundle:Template:templateCaller.html.twig',
                     array(
                         'template' => $this->template,
                         'view' => $this->getViewParameters(),
                         'vars' => $vars,
                         )
                    );
        }
        else
            throw new \InvalidArgumentException(
                    "Unknown action %s in %s",
                    $this->actionName,
                    get_class($this)
                    );       
    }
    
    protected function  setLayout($layout)
    {
        $this->layout = $layout;
    }
    
    protected function  setTemplate($template)
    {
        $this->template = $template;
    }
    
    public function     setAction($actionName)
    {
        $this->actionName = $actionName;
    }
    
    private function    getName()
    {
        preg_match('#([a-zA-Z0-9]+)Action#', $this->actionName, $res);
        return ($res[1]);
    }
    
    private function    getFolder()
    {
        preg_match(
                '#([a-zA-Z0-9]+)\\\([a-zA-Z0-9]+)\\\Controller#',
                $this->refClass->getNamespaceName(),
                $res
                );
        return ($res[1] . $res[2]);
    }
    
    private function    getNamespace()
    {
        preg_match(
                '#([a-zA-Z0-9]+)Controller#',
                $this->refClass->getName(),
                $res
                );
        return ($res[1]);
    }
    
    private function    getTemplate()
    {
        $name = $this->getName();
        $namespace = $this->getNamespace();
        $folder = $this->getFolder();
        return ($folder . ':' . $namespace . ':' . $name . '.html.twig');
    }
    
    private function    getBaseLayout()
    {
        $folder = $this->getFolder();
        return ($folder . '::layout.html.twig');
    }
    
    private function    getViewParameters()
    {
        $conf = $this->container->getParameter('core_easy_action.views');
        
        if (!isset($conf[$this->getFolder()][strtolower($this->getNamespace())]))
        {
            $conf = array(
              'metas' => NULL,
              'stylesheets' => NULL,
              'javascripts' => NULL,
              'title' => '',
              'layout' => '',
            );
        }
        else
            $conf = $conf[$this->getFolder()][strtolower($this->getNamespace())];
        
        if ($conf['layout'] == '' && $this->layout != NULL)
            $conf['layout'] = $this->layout;
        else if ($this->layout == NULL)
            $conf['layout'] = NULL;
        else
            $conf['layout'] = $this->getBaseLayout();
        return ($conf);
    }
    
    /**
     * Check if the request is secure
     * 
     * @return bool
     */
    protected function requestIsSecure()
    {
        return SecureLinkHelper::isSecure($this->get('form.factory'), $this->getRequest());
    }
    
    /**
     * Get EntityManager
     * 
     * @return Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }
    
    protected function preActionControl()
    {
        return NULL;
    }
}
