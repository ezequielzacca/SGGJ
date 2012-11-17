<?php

namespace Gremio\AbmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gremio\AbmBundle\Entity\TipoSocio;
use Gremio\AbmBundle\Form\TipoSocioType;

/**
 * TipoSocio controller.
 *
 * @Route("/administracion/entidades/tiposocio")
 */
class TipoSocioController extends Controller
{
    /**
     * Lists all TipoSocio entities.
     *
     * @Route("/", name="administracion_entidades_tiposocio")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('GremioAbmBundle:TipoSocio')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a TipoSocio entity.
     *
     * @Route("/{id}/show", name="administracion_entidades_tiposocio_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioAbmBundle:TipoSocio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoSocio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new TipoSocio entity.
     *
     * @Route("/new", name="administracion_entidades_tiposocio_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TipoSocio();
        $form   = $this->createForm(new TipoSocioType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new TipoSocio entity.
     *
     * @Route("/create", name="administracion_entidades_tiposocio_create")
     * @Method("post")
     * @Template("GremioAbmBundle:TipoSocio:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new TipoSocio();
        $request = $this->getRequest();
        $form    = $this->createForm(new TipoSocioType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administracion_entidades_tiposocio_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing TipoSocio entity.
     *
     * @Route("/{id}/edit", name="administracion_entidades_tiposocio_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioAbmBundle:TipoSocio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoSocio entity.');
        }

        $editForm = $this->createForm(new TipoSocioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing TipoSocio entity.
     *
     * @Route("/{id}/update", name="administracion_entidades_tiposocio_update")
     * @Method("post")
     * @Template("GremioAbmBundle:TipoSocio:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioAbmBundle:TipoSocio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoSocio entity.');
        }

        $editForm   = $this->createForm(new TipoSocioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('administracion_entidades_tiposocio_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a TipoSocio entity.
     *
     * @Route("/{id}/delete", name="administracion_entidades_tiposocio_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('GremioAbmBundle:TipoSocio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoSocio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administracion_entidades_tiposocio'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
