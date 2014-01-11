<?php

namespace Core\ToolsBundle\Helper;
use Symfony\Component\Yaml\Yaml;
use \Symfony\Component\HttpFoundation\Request;

class BaseHelper
{
    public static function getRouteFromRole($role)
    {
        if (preg_match('#^ROLE_(.+)$#', $role, $result))
             return (ucwords(strtolower($result[1])) . 'Homepage');
        return (NULL);
    }
    
    public static function getHomeRouteFromAccess(Request $request)
    {
        $links = array(
            'administration' => 'AdmHomepage',
            'backend' => 'BackendHomepage',
            'teacher' => 'TeacherHomepage',
            'tutor' => 'TutorHomepage',
            'student' => 'StudentHomepage'
        );
        return ($links[self::getAccessFromRequest($request)]);
    }
    
    public static function getMessengerRouteFromAccess(Request $request)
    {
        $links = array(
            'administration' => 'AdministrationMessenger_listNew',
            'backend' => 'BackendMessenger_listNew',
            'teacher' => 'TeacherMessenger_listNew',
            'tutor' => 'TutorMessenger_listNew',
            'student' => 'StudentMessenger_listNew'
        );
        return ($links[self::getAccessFromRequest($request)]);
    }
    
    public static function getLinkFromRole($role)
    {
        $links = array(
            'ROLE_ADM' => array('name' => 'Accès Administratif', 'link' => 'AdmHomepage'),
            'ROLE_BACKEND' => array('name' => 'Accès Administrateur', 'link' => 'BackendHomepage'),
            'ROLE_TEACHER' => array('name' => 'Accès Professeur', 'link' => 'TeacherHomepage'),
            'ROLE_TUTOR' => array('name' => 'Accès Tuteur', 'link' => 'TutorHomepage'),
            'ROLE_STUDENT' => array('name' => 'Accès Etudiant', 'link' => 'StudentHomepage')
        );
        
        return ((isset($links[$role])) ? ($links[$role]) : (NULL));
    }
    
    public static function getLinksFromRoles($roles)
    {
        $links = array();
        foreach ($roles as $role)
        {
            if (($link = self::getLinkFromRole($role)))
                    $links[] = $link;
        }
        return ($links);
    }
    
    public static function getAccessFromRequest(Request $request)
    {   
        $path = explode('/', $request->getPathInfo());
        return ($path[1]);
    }
    
    public static function printUserProfileAccordingToAccess($user, $container)
    {
        $access = self::getAccessFromRequest($container->get('request'));
        $controllerName = ucwords($access) . '\MainBundle\Controller\ComponentsController';
        if (class_exists($controllerName))
        {
            $controller = new $controllerName();
            $controller->setContainer($container);
            if (method_exists($controller, 'displayUserPopoverAction'))
            {
                $currentUser = $container->get('security.context')->getToken()->getUser();
                $rendering = $controller->displayUserPopoverAction($currentUser, $user);
                $rendering = str_replace("\n", '', $rendering);
                $rendering = str_replace("\r", '', $rendering);
                $rendering = addslashes($rendering);
                return $rendering;
            }
        }
        return null;
    }
}
?>
