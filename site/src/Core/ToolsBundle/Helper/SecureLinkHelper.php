<?php

namespace Core\ToolsBundle\Helper;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class SecureLinkHelper
{
    /**
     * Build Secure Form
     * 
     * @param Symfony\Component\Form\FormFactoryInterface $formFactory
     * @return  Symfony\Component\Form
     */
    public static function buildForm(FormFactoryInterface $formFactory)
    {
        return $formFactory->createNamedBuilder('form', '_secure_request')
                ->getForm();
    }
    
    /**
     *
     * @param FormFactoryInterface $formFactory
     * @param Request $request
     * @return bool 
     */
    public static function isSecure(FormFactoryInterface $formFactory, Request $request)
    {
        $form = self::buildForm($formFactory)->bindRequest($request);
        if ($form->isValid())
           return true;
        return false;
    }
}
?>