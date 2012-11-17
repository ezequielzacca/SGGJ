<?php

namespace Gremio\ProveedoresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gremio\ProveedoresBundle\Entity\Proveedor;
use Gremio\ProveedoresBundle\Form\EventoType;

/**
 * Proveedor controller.
 *
 * @Route("/administracion/entidades/evento")
 */
class EventoController extends Controller {

    /**
     * Lists all Evento entities.
     *
     * @Route("/", name="administracion_entidades_evento")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('GremioProveedoresBundle:Proveedor')->findEventos();

        return array('entities' => $entities);
    }

    
    
    
    /**
     * Lists all available Proveedor entities.
     *
     * @Route("/lista/eventos", name="lista_eventos")
     * @Template()
     */
    public function listaAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('GremioProveedoresBundle:Proveedor')->findEventosVigentes();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Proveedor entity.
     *
     * @Route("/{id}/show", name="administracion_entidades_evento_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioProveedoresBundle:Proveedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evrento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),);
    }

    /**
     * Displays a form to create a new Proveedor entity.
     *
     * @Route("/new", name="administracion_entidades_evento_new")
     * @Template()
     */
    public function newAction() {
        $entity = new Proveedor();
        $form = $this->createForm(new EventoType(), $entity);
        

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new Proveedor entity.
     *
     * @Route("/create", name="administracion_entidades_evento_create")
     * @Method("post")
     * @Template("GremioProveedoresBundle:Evento:new.html.twig")
     */
    public function createAction() {
        $entity = new Proveedor();
        $request = $this->getRequest();
        $form = $this->createForm(new EventoType(), $entity);
        $form->bindRequest($request);
        $entity->setEvento(true);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administracion_entidades_evento_show', array('id' => $entity->getId())));
            $this->get('session')->setFlash('succes',
                            'El Evento fue dado de Alta Exitosamente!');
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Proveedor entity.
     *
     * @Route("/{id}/edit", name="administracion_entidades_evento_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioProveedoresBundle:Proveedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evento entity.');
        }

        $editForm = $this->createForm(new EventoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Proveedor entity.
     *
     * @Route("/{id}/update", name="administracion_entidades_evento_update")
     * @Method("post")
     * @Template("GremioProveedoresBundle:Evento:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioProveedoresBundle:Proveedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Evento entity.');
        }

        $editForm = $this->createForm(new EventoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('succes',
                            'El Evento fue modificado Exitosamente!');
            return $this->redirect($this->generateUrl('administracion_entidades_evento'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Proveedor entity.
     *
     * @Route("/{id}/delete", name="administracion_entidades_evento_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('GremioProveedoresBundle:Proveedor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Proveedor entity.');
            }
            if ($entity->getFechaBaja()) {
                $entity->setFechaBaja(null);
                $entity->setUsuarioBaja(null);
                $this->get('session')->setFlash('succes',
                            'El Evento fue dado de Alta Exitosamente!');
            } else {
                $entity->setFechaBaja(new \DateTime());
                $entity->setUsuarioBaja($this->get('security.context')->getToken()->getUser()->getUsername());
                $this->get('session')->setFlash('succes',
                            'El Evento fue dado de Baja Exitosamente!');
            }
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administracion_entidades_evento'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

}
