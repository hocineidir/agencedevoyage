<?php

// src/AppBundle/Menu/MenuBuilder.php
namespace App\Menu;

use Knp\Menu\FactoryInterface;
// use Symfony\Component\DependencyInjection\ContainerAwareInterface;
// use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * MenuBuilder en tant que service (cf. http://symfony.com/doc/master/bundles/KnpMenuBundle/menu_builder_service.html)
 *
 */
class MenuBuilder
{
    private $factory;
    private $container;
    
    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, Container $container)
    {
        $this->factory = $factory;
        $this->container = $container;
    }
    
    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        
        $menu->addChild('Accueil', array('route' => 'frontoffice_home'));
       
        return $menu;
    }
    
    public function createLoginMenu(array $options) {
        $menu = $this->factory->createItem('root');
        
        $menu->addChild('Connexion', array('route' => 'fos_user_security_login'));
        return $menu;
    }
    
    public function createEtapesMenu(array $options) {
        $menu = $this->factory->createItem('root');
        
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $menu->addChild('Etapes', array('route' => 'admin_etape_index'));
        }
        return $menu;
    }
    
    public function createCircuitsMenu(array $options) {
        $menu = $this->factory->createItem('root');
        
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $menu->addChild('Circuits', array('route' => 'admin_circuit_index'));
        }
        return $menu;
    }
    
    public function createUserMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        
        //if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))) {} // Check if the visitor has any authenticated roles
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            // Get username of the current logged in user
            $username = $this->container->get('security.token_storage')->getToken()->getUser()->getUsername();
            $label = 'Bienvenue '. $username .'!';
     
        }
        else 
       {
            $label = 'Bienvenue!'; 
        }
        $menu->addChild('User', array('label' => $label));
        return $menu;
    }
    
}
