<?php

namespace Gremio\ProveedoresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gremio\ProveedoresBundle\Entity\Cajero;
use Gremio\ProveedoresBundle\Form\CajeroType;

/**
 * Cajero controller.
 *
 * @Route("/administracion/entidades/cajero")
 */
class CajeroController extends Controller
{
    /**
     * Lists all Cajero entities.
     *
     * @Route("/", name="administracion_entidades_cajero")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('GremioProveedoresBundle:Cajero')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Cajero entity.
     *
     * @Route("/{id}/show", name="administracion_entidades_cajero_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioProveedoresBundle:Cajero')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cajero entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Cajero entity.
     *
     * @Route("/new", name="administracion_entidades_cajero_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Cajero();
        $form   = $this->createForm(new CajeroType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Cajero entity.
     *
     * @Route("/create", name="administracion_entidades_cajero_create")
     * @Method("post")
     * @Template("GremioProveedoresBundle:Cajero:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Cajero();
        $request = $this->getRequest();
        $form    = $this->createForm(new CajeroType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->setFlash('succes',
                            'El Cajero fue creado con Exito!');
            return $this->redirect($this->generateUrl('administracion_entidades_cajero'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Cajero entity.
     *
     * @Route("/{id}/edit", name="administracion_entidades_cajero_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioProveedoresBundle:Cajero')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cajero entity.');
        }

        $editForm = $this->createForm(new CajeroType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Cajero entity.
     *
     * @Route("/{id}/update", name="administracion_entidades_cajero_update")
     * @Method("post")
     * @Template("GremioProveedoresBundle:Cajero:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GremioProveedoresBundle:Cajero')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cajero entity.');
        }

        $editForm   = $this->createForm(new CajeroType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('succes',
                            'Los Datos del Cajero fueron modificados Exitosamente!');
            return $this->redirect($this->generateUrl('administracion_entidades_cajero'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Cajero entity.
     *
     * @Route("/{id}/delete", name="administracion_entidades_cajero_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('GremioProveedoresBundle:Cajero')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cajero entity.');
            }
            if($entity->getFechaBaja())
            {
                $entity->setFechaBaja(null);
                $entity->setUsuarioBaja(null);
                $this->get('session')->setFlash('succes',
                            'El Cajero fue dado de Alta Exitosamente!');
            
            }
            else
            {
                $entity->setFechaBaja(new \DateTime());
                $entity->setUsuarioBaja($this->get('security.context')->getToken()->getUser()->getUsername());
                $this->get('session')->setFlash('succes',
                            'El Cajero fue dado de Baja Exitosamente!');
            }
            
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administracion_entidades_cajero'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
