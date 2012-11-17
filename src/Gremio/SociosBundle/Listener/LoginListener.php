<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Gremio\SociosBundle\Listener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginListener
{
    private $router,$contexto,$session = null;
    private $redirigir = false;
    
    
    public function __construct(SecurityContext $context, Router $router)
    {
        $this->router = $router;
        $this->contexto = $context;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $usuario = $event->getAuthenticationToken()->getUser();
        $this->redirigir = true;
        
    }
    
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if($this->redirigir)
        {
            if($this->contexto->isGranted('ROLE_SOCIO'))
            {
            $pagina = $this->router->generate('socio_panel');
            $event->setResponse(new RedirectResponse($pagina));
            $event->stopPropagation();


            }
            else if($this->contexto->isGranted('ROLE_PROVEEDOR'))
            {
            $pagina = $this->router->generate('proveedores');
            $event->setResponse(new RedirectResponse($pagina));
            $event->stopPropagation();
            }
            else if($this->contexto->isGranted('ROLE_GREMIO'))
            {
            $pagina = $this->router->generate('socio');
            $event->setResponse(new RedirectResponse($pagina));
            $event->stopPropagation();
            }
        }
        
    }
}

