<?php

namespace Gremio\AbmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gremio\AbmBundle\Form\UsuarioPasswordType;
use Gremio\AbmBundle\Entity\Socio;
use Gremio\ProveedoresBundle\Entity\Cajero;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;


    /**
     * @Route("/Cuenta")
     * 
     */
class CuentaController extends Controller
{
    /**
     * Conduce a un formulario de cambio de contraseña
     *
     * @Route("/password", name="password")
     * 
     */
    public function cambiarContraseñaAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $formulario = $this->createForm(new UsuarioPasswordType(),$usuario);
        $peticion = $this->getRequest();
        if($peticion->getMethod()=='POST')
        {
            $formulario->bindRequest($peticion);
            if($formulario->isValid())
            {
                $encoder = $this->get('security.encoder_factory')
                                 ->getEncoder($usuario);
                $passwordCodificado = $encoder->encodePassword($usuario->getPassword(),
                        $usuario->getSalt());
                $usuario->setPassword($passwordCodificado);
                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();
                
                $this->get('session')->setFlash('info',
                    'Tu Contraseña fue actualizada correctamente');
                return $this->redirect($this->generateUrl('home'));
            }
        }
        return $this->render('GremioAbmBundle:Cuenta:cambioPassword.html.twig'
                ,array(
                    'usuario' => $usuario,
                    'formulario' => $formulario->createView()
                
                ));
    }
    
    
    /**
     * Conduce a un formulario de cambio de contraseña
     *
     * @Route("/recuperar/datos", name="recuperar_datos")
     * 
     */
    public function recordarDatosAction()
    {
        
        $peticion = $this->getRequest();
        
        if($peticion->getMethod()=='POST')
        {
        
        $email= $peticion->request->get('email');
        
        $em= $this->getDoctrine()->getEntityManager();
        
        $consulta = $em->createQuery('SELECT s from GremioAbmBundle:Socio s 
                                      WHERE s.Email=?1');
        $consulta->setParameter(1,$email);
        $consulta->setMaxResults(1);
        $usuarios=$consulta->getResult();
        $usuario = $usuarios[0];
        
       if(!$usuario)
       {
             $consulta = $em->createQuery('SELECT s from GremioProveedoresBundle:Cajero s 
                                      WHERE s.email=?1');
             $consulta->setParameter(1,$email);
             $usuario = $consulta->getSingleResult();
       }
        
        //se resetea la contraseña del Usuario
         $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
         
                $passwordCodificado = $encoder->encodePassword('Aa123456',
                        $usuario->getSalt());
        
                $usuario->setPassword($passwordCodificado);
                $em->flush();
        $message = \Swift_Message::newInstance()
            ->setSubject('Datos de Cuenta')
            ->setFrom('gremiojudiciales@symblog.co.uk')
            ->setTo($usuario->getEmail())
            ->setBody($this->renderView('GremioAbmBundle:Mails:recuperarEmail.txt.twig', array('usuario' => $usuario)));
        $this->get('mailer')->send($message);
            if($peticion->isXmlHttpRequest())
            {
                 return new Response('<p>Se envio un E-Mail a la Direccion de Correo solicitada con los Datos del Usuario</p>');
            }
        }   
        
        
            return $this->render('GremioAbmBundle:Cuenta:recuperarDatos.html.twig');
        
        
    }
}
