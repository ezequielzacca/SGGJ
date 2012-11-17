<?php

namespace Gremio\AbmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gremio\AbmBundle\Entity\Reparticion;
use Gremio\AbmBundle\Form\ReparticionType;

/**
 * Reparticion controller.
 *
 * @Route("/administracion/entidades/reparticion")
 */
class ReparticionController extends Controller
{
    /**
     * Lists all Reparticion entities.
     *
     * @Route("/", name="administracion_entidades_reparticion")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('GremioAbmBundle:Reparticion')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Reparticion entity.
     *
     * @Route("/{id}/show", name="administracion_entidades_reparticion_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioAbmBundle:Reparticion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reparticion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Reparticion entity.
     *
     * @Route("/new", name="administracion_entidades_reparticion_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Reparticion();
        $form   = $this->createForm(new ReparticionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Reparticion entity.
     *
     * @Route("/create", name="administracion_entidades_reparticion_create")
     * @Method("post")
     * @Template("GremioAbmBundle:Reparticion:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Reparticion();
        $request = $this->getRequest();
        $form    = $this->createForm(new ReparticionType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administracion_entidades_reparticion_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Reparticion entity.
     *
     * @Route("/{id}/edit", name="administracion_entidades_reparticion_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioAbmBundle:Reparticion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reparticion entity.');
        }

        $editForm = $this->createForm(new ReparticionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Reparticion entity.
     *
     * @Route("/{id}/update", name="administracion_entidades_reparticion_update")
     * @Method("post")
     * @Template("GremioAbmBundle:Reparticion:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioAbmBundle:Reparticion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reparticion entity.');
        }

        $editForm   = $this->createForm(new ReparticionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administracion_entidades_reparticion'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Reparticion entity.
     *
     * @Route("/{id}/delete", name="administracion_entidades_reparticion_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('GremioAbmBundle:Reparticion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Reparticion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administracion_entidades_reparticion'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
