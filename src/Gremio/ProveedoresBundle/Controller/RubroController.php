<?php

namespace Gremio\ProveedoresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gremio\ProveedoresBundle\Entity\Rubro;
use Gremio\ProveedoresBundle\Form\RubroType;

/**
 * Rubro controller.
 *
 * @Route("/administracion/entidades/rubro")
 */
class RubroController extends Controller {

    /**
     * Lists all Rubro entities.
     *
     * @Route("/", name="administracion_entidades_rubro")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('GremioProveedoresBundle:Rubro')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Rubro entity.
     *
     * @Route("/{id}/show", name="administracion_entidades_rubro_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioProveedoresBundle:Rubro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rubro entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),);
    }

    /**
     * Displays a form to create a new Rubro entity.
     *
     * @Route("/new", name="administracion_entidades_rubro_new")
     * @Template()
     */
    public function newAction() {
        $entity = new Rubro();
        $form = $this->createForm(new RubroType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new Rubro entity.
     *
     * @Route("/create", name="administracion_entidades_rubro_create")
     * @Method("post")
     * @Template("GremioProveedoresBundle:Rubro:new.html.twig")
     */
    public function createAction() {
        $entity = new Rubro();
        $request = $this->getRequest();
        $form = $this->createForm(new RubroType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('succes', 'El Rubro fue creado con Exito!');
            return $this->redirect($this->generateUrl('administracion_entidades_rubro'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Rubro entity.
     *
     * @Route("/{id}/edit", name="administracion_entidades_rubro_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioProveedoresBundle:Rubro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rubro entity.');
        }

        $editForm = $this->createForm(new RubroType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Rubro entity.
     *
     * @Route("/{id}/update", name="administracion_entidades_rubro_update")
     * @Method("post")
     * @Template("GremioProveedoresBundle:Rubro:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioProveedoresBundle:Rubro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rubro entity.');
        }

        $editForm = $this->createForm(new RubroType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('succes', 'Los Datos del Rubro fueron modificados Exitosamente!');

            return $this->redirect($this->generateUrl('administracion_entidades_rubro'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Rubro entity.
     *
     * @Route("/{id}/delete", name="administracion_entidades_rubro_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('GremioProveedoresBundle:Rubro')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Rubro entity.');
            }
            if ($entity->getFechaBaja()) {
                $entity->setFechaBaja(null);
                $entity->setUsuarioBaja(null);
                $this->get('session')->setFlash('succes', 'El Rubro fue dado de Alta Exitosamente!');
            } else {
                $entity->setFechaBaja(new \DateTime());
                $entity->setUsuarioBaja($this->get('security.context')->getToken()->getUser()->getUsername());
                $this->get('session')->setFlash('succes', 'El Rubro fue dado de Baja Exitosamente!');
            }

            $em->flush();
        }

        return $this->redirect($this->generateUrl('administracion_entidades_rubro'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

}
