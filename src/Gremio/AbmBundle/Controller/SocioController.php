<?php

namespace Gremio\AbmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gremio\AbmBundle\Entity\Socio;
use Gremio\AbmBundle\Form\SocioType;
use Gremio\SociosBundle\Entity\Emision;
use Gremio\SociosBundle\Entity\CuotaEmision;
use Gremio\SociosBundle\Form\GeneraCompraType;
use Gremio\SociosBundle\Form\GeneraCombustibleType;
use Gremio\SociosBundle\Form\GeneraPasajeType;
use Gremio\SociosBundle\Form\GeneraPrestamoType;
use Gremio\SociosBundle\Form\GeneraEventoType;
use Gremio\SociosBundle\Entity\TipoEmision;
use Gremio\AbmBundle\Entity\Baja;

/**
 * Socio controller.
 *
 * @Route("/administracion/entidades/socios")
 */
class SocioController extends Controller {

    /**
     * Lists all Socio entities.
     *
     * @Route("/", name="socio")
     * @Template()
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getEntityManager();
        $criterio_palabra = $this->getRequest()->query->get('apellido');
        $criterio_seleccion = $this->getRequest()->query->get('seleccion');
        if ($criterio_palabra != null) {
            $entities = $em->getRepository('GremioAbmBundle:Socio')->findByCriterio($criterio_palabra, $criterio_seleccion);
        }
        else
            $entities = $em->getRepository('GremioAbmBundle:Socio')->findAll();

        return array('entities' => $entities);
    }

    /**
     *
     * Lists all Socio entities in a search form.
     *
     * @Route("/busqueda", name="busqueda")
     * @Template()
     */
    public function busquedaAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('GremioAbmBundle:Socio')->findAll();
        return array('entities' => $entities, 'busquedas' => true);
    }

    /**
     * Finds and displays a Socio entity.
     *
     * @Route("/{id}/show/{tipo}", requirements={"tipo"="compra|combustible|prestamo|pasajes|evento"}, defaults={"tipo"="compra"}, name="socio_show")
     * @Template()
     */
    public function showAction($id, $tipo) {
        $peticion = $this->get('request');
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioAbmBundle:Socio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Socio entity.');
        }
        $emisiones = $em->getRepository('GremioSociosBundle:Emision')->findUltimasDelSocio($entity->getId());
        $fecha = new \DateTime();
        $deleteForm = $this->createDeleteForm($id, $fecha);

        $emision = new Emision();
        $margen = $this->get('my_util')->getMargen($entity);



        $formcompra = $this->createForm(new GeneraCompraType(), $emision);
        $formcombustible = $this->createForm(new GeneraCombustibleType(), $emision);
        $formpasaje = $this->createForm(new GeneraPasajeType(), $emision);
        $formprestamo = $this->createForm(new GeneraPrestamoType(), $emision);
        $formevento = $this->createForm(new GeneraEventoType(),$emision);


        if ($peticion->getMethod() == 'POST') {

            $emision->setUsuarioEmision($this->get('security.context')->getToken()->getUser()->getUsername());
            $emision->setSocio($entity);

            $emision->setFechaEmision(new \DateTime());
            $fechaValidez = date_create(date('Ym01'))->modify('+1 month -1 day');
            $emision->setFechaValidez($fechaValidez);
            if ($tipo == 'compra') {
                $formcompra->bindRequest($peticion);
                if ($formcompra->isValid()) {

                    $consulta = $em->createQuery('SELECT e from GremioSociosBundle:TipoEmision e  
                                        WHERE e.descripcion=?1');
                    $consulta->setParameter(1, 'Vale de Compras');
                    $tipoemision = $consulta->getSingleResult();
                    $emision->setTipoEmision($tipoemision);
                    if ($emision->getImporte() <= $entity->getMargen()) {

                        $em->persist($emision);

                        $em->flush();
                        $this->get('session')->setFlash('info', 'La Orden de Compra fue generada correctamente');
                        return $this->redirect($this->generateUrl('socio_show', array('id' => $entity->getId())) . '#formularios');
                    } else {
                        $this->get('session')->setFlash('error-compra', 'El importe ingresado es mayor que el margen disponible');
                        return $this->redirect($this->generateUrl('socio_show', array('id' => $entity->getId())) . '#formularios');
                    }
                }
            } else if ($tipo == 'pasajes') {
                $formpasaje->bindRequest($peticion);
                if ($formpasaje->isValid()) {
                    $emision->setCantidadCuotas(1);
                    $em = $this->getDoctrine()->getEntityManager();
                    $consulta = $em->createQuery('SELECT e from GremioSociosBundle:TipoEmision e  
                                        WHERE e.descripcion=?1');
                    $consulta->setParameter(1, 'Orden de Pasajes');
                    $tipoemision = $consulta->getSingleResult();
                    $emision->setTipoEmision($tipoemision);
                    if ($emision->getImporte() <= $entity->getMargen()) {
                        $em->persist($emision);

                        $em->flush();
                        $this->get('session')->setFlash('info', 'La Orden de Pasajes fue generada correctamente');
                        return $this->redirect($this->generateUrl('socio_show', array('id' => $entity->getId())));
                    } else {
                        $this->get('session')->setFlash('error-pasajes', 'El importe ingresado es mayor que el margen disponible');
                        return $this->redirect($this->generateUrl('socio_show', array('id' => $entity->getId())) . '#formularios');
                    }
                }
            } else if ($tipo == 'combustible') {
                $formcombustible->bindRequest($peticion);
                if ($formcombustible->isValid()) {
                    $emision->setCantidadCuotas(1);
                    $em = $this->getDoctrine()->getEntityManager();
                    $consulta = $em->createQuery('SELECT e from GremioSociosBundle:TipoEmision e  
                                        WHERE e.descripcion=?1');
                    $consulta->setParameter(1, 'Vale de Combustible');
                    $tipoemision = $consulta->getSingleResult();
                    $emision->setTipoEmision($tipoemision);
                    if ($emision->getImporte() <= $entity->getMargen()) {
                        $em->persist($emision);

                        $em->flush();
                        $this->get('session')->setFlash('info', 'La Orden de Carga de Combustible fue generada correctamente');
                        return $this->redirect($this->generateUrl('socio_show', array('id' => $entity->getId())));
                    } else {
                        $this->get('session')->setFlash('error-combustible', 'El importe ingresado es mayor que el margen disponible');
                        return $this->redirect($this->generateUrl('socio_show', array('id' => $entity->getId())) . '#formularios');
                    }
                }
            } else if ($tipo == 'prestamo') {
                $formprestamo->bindRequest($peticion);
                if ($formprestamo->isValid()) {

                    $em = $this->getDoctrine()->getEntityManager();
                    $consulta = $em->createQuery('SELECT e from GremioSociosBundle:TipoEmision e  
                                        WHERE e.descripcion=?1');
                    $consulta->setParameter(1, 'Prestamo');
                    $tipoemision = $consulta->getSingleResult();
                    $emision->setTipoEmision($tipoemision);
                    if ($emision->getImporte() <= $entity->getMargen()) {

                        $em->persist($emision);

                        $em->flush();
                        $this->get('session')->setFlash('info', 'La Orden de Prestamo fue generada correctamente');
                        return $this->redirect($this->generateUrl('socio_show', array('id' => $entity->getId())) . '#formularios');
                    } else {
                        $this->get('session')->setFlash('error-prestamo', 'El importe ingresado es mayor que el margen disponible');
                        return $this->redirect($this->generateUrl('socio_show', array('id' => $entity->getId())) . '#formularios');
                    }
                }
            } else if ($tipo == 'evento') {
                $formevento->bindRequest($peticion);
                if ($formevento->isValid()) {

                    $em = $this->getDoctrine()->getEntityManager();
                    $consulta = $em->createQuery('SELECT e from GremioSociosBundle:TipoEmision e  
                                        WHERE e.descripcion=?1');
                    $consulta->setParameter(1, 'Evento');
                    $tipoemision = $consulta->getSingleResult();
                    $emision->setTipoEmision($tipoemision);
                    if ($emision->getImporte() <= $entity->getMargen()) {
                        $ahora = new \DateTime();
                        $ahoraFormateado = $ahora->format('dmYhis');
                        $codigoAprovacion = $emision->getId() . $ahora->format('dmYhis');
                        $emision->setCodigoAprovacion($codigoAprovacion);
                        for ($i = 1; $i <= $emision->getCantidadCuotas(); $i++) {
                            $ahora = new \DateTime();
                            $cuota = new CuotaEmision();
                            $cuota->setEmision($emision);
                            $cuota->setProcesada(false);
                            $cuota->setNumeroCuota($i);
                            $mes = $ahora->format('n') + $i - 1;
                            $anio = $ahora->format('Y');
                            $cuota->setImporteCuota(round($emision->getImporte() / $emision->getCantidadCuotas() * 100) / 100);
                            $fechaVencimiento = \DateTime::createFromFormat('d/n/Y', '01/' . $mes . '/' . $anio);
                            $cuota->setFechaVencimiento($fechaVencimiento);
                            $em->persist($cuota);
                        }
                        $em->persist($emision);

                        $em->flush();
                        $this->get('session')->setFlash('info', 'El socio se suscribio al evento correctamente');
                        return $this->redirect($this->generateUrl('socio_show', array('id' => $entity->getId())) . '#formularios');
                    } else {
                        $this->get('session')->setFlash('error-prestamo', 'El importe ingresado es mayor que el margen disponible');
                        return $this->redirect($this->generateUrl('socio_show', array('id' => $entity->getId())) . '#formularios');
                    }
                }
            }
        }




        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            'emisiones' => $emisiones,
            'form_compra' => $formcompra->createView(),
            'form_combustible' => $formcombustible->createView(),
            'form_pasajes' => $formpasaje->createView(),
            'form_prestamo' => $formprestamo->createView(),
            'form_evento' => $formevento->createView(),
            'margen' => $margen);
    }

    /**
     * Displays a form to create a new Socio entity.
     *
     * @Route("/new", name="socio_new")
     * @Template()
     */
    public function newAction() {
        $entity = new Socio();
        $form = $this->createForm(new SocioType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new Socio entity.
     *
     * @Route("/create", name="socio_create")
     * @Method("post")
     * @Template("GremioAbmBundle:Socio:new.html.twig")
     */
    public function createAction() {
        $entity = new Socio();
        $request = $this->getRequest();
        $form = $this->createForm(new SocioType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('succes', 'Socio creado con Exito!');
            return $this->redirect($this->generateUrl('socio'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Socio entity.
     *
     * @Route("/{id}/edit", name="socio_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioAbmBundle:Socio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Socio entity.');
        }

        $editForm = $this->createForm(new SocioType(), $entity);
        $fecha = new Baja();
        $deleteForm = $this->createFormBuilder($fecha)
                ->add('fecha_baja', 'date', array(
                    'widget' => 'single_text', 'format' => 'dd/MM/yyyy',
                ))
                ->getForm()
        ;

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Socio entity.
     *
     * @Route("/{id}/update", name="socio_update")
     * @Method("post")
     * @Template("GremioAbmBundle:Socio:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioAbmBundle:Socio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Socio entity.');
        }
        $editForm = $this->createForm(new SocioType(), $entity);


        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('succes', 'Los Datos del Socio fueron modificados Exitosamente!');


            return $this->redirect($this->generateUrl('socio'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Socio entity.
     *
     * @Route("/{id}/delete", name="socio_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
        $fecha = new Baja();
        $deleteForm = $this->createFormBuilder($fecha)
                ->add('fecha_baja', 'date', array(
                    'widget' => 'single_text', 'format' => 'dd/MM/yyyy',
                ))
                ->getForm()
        ;
        $request = $this->getRequest();

        $deleteForm->bindRequest($request);



        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GremioAbmBundle:Socio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Socio entity.');
        }

        $ultimasBajas = $em->getRepository('GremioAbmBundle:Baja')->findDelSocio($entity->getId());

        foreach ($ultimasBajas as $ultimaBaja) {
            if (!($fecha->getFechaBaja() < $ultimaBaja->getFechaBaja())) {
                $ultimaBaja->setFechaCancelaBaja($fecha->getFechaBaja());
                $ultimaBaja->setUsuarioCancelaBaja($this->get('security.context')->getToken()->getUser()->getUsername());
                $this->get('session')->setFlash('succes', 'La Fecha de Alta fue grabada Exitosamente!');
            } else {
                $this->get('session')->setFlash('error', 'La Fecha de Alta no puede ser anterior a la Fecha de Baja');
                return $this->redirect($this->generateUrl('socio_edit', array('id' => $id)));
            }
        }
        if (!$ultimasBajas) {
            if (!($fecha->getFechaBaja() < new \DateTime() )) {
                $baja = new Baja();
                $baja->setSocio($entity);
                $baja->setFechaBaja($fecha->getFechaBaja());
                $baja->setUsuarioBaja($this->get('security.context')->getToken()->getUser()->getUsername());
                $em->persist($baja);
                $this->get('session')->setFlash('succes', 'La Fecha de Baja fue grabada Exitosamente!');
            } else {
                $this->get('session')->setFlash('error', 'La Fecha de Baja no puede ser anterior a la Fecha de Hoy');
                return $this->redirect($this->generateUrl('socio_edit', array('id' => $id)));
            }
        }
        $em->flush();


        return $this->redirect($this->generateUrl('socio'));
    }

    private function createDeleteForm($id, $fecha) {
        return $this->createFormBuilder(array('id' => $id, 'fecha' => $fecha))
                        ->add('id', 'hidden')
                        ->add('fecha', 'date', array(
                            'widget' => 'single_text', 'format' => 'dd/MM/yyyy',
                        ))
                        ->getForm()
        ;
    }

}
