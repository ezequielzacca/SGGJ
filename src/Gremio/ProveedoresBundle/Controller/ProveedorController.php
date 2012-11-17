<?php

namespace Gremio\ProveedoresBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gremio\ProveedoresBundle\Entity\Proveedor;
use Gremio\ProveedoresBundle\Form\ProveedorType;

/**
 * Proveedor controller.
 *
 * @Route("/administracion/entidades/proveedor")
 */
class ProveedorController extends Controller {

	/**
	 * Lists all Proveedor entities.
	 *
	 * @Route("/", name="administracion_entidades_proveedor")
	 * @Template()
	 */
	public function indexAction() {
		$em = $this->getDoctrine()->getEntityManager();

		$entities = $em->getRepository('GremioProveedoresBundle:Proveedor')
				->findAll();

		return array('entities' => $entities);
	}

	/**
	 * Lists all available Proveedor entities.
	 *
	 * @Route("/lista", name="lista_proveedores")
	 * @Template()
	 */
	public function listaAction() {
		$em = $this->getDoctrine()->getEntityManager();
		$entities = $em->getRepository('GremioProveedoresBundle:Proveedor')
				->findVigentes();

		return array('entities' => $entities);
	}

	/**
	 * Finds and displays a Proveedor entity.
	 *
	 * @Route("/{id}/show", name="administracion_entidades_proveedor_show")
	 * @Template()
	 */
	public function showAction($id) {
		$em = $this->getDoctrine()->getEntityManager();

		$entity = $em->getRepository('GremioProveedoresBundle:Proveedor')
				->find($id);

		if (!$entity) {
			throw $this
					->createNotFoundException(
							'Unable to find Proveedor entity.');
		}
		$importePago = $em->getRepository('GremioAbmBundle:PagoAProveedor')
				->findImporteAPagar($entity->getId());
		$deleteForm = $this->createDeleteForm($id);

		return array('entity' => $entity, 'importe_pago' => $importePago,
				'delete_form' => $deleteForm->createView(),);
	}

	/**
	 * Registra el pago a un proveedor
	 *
	 * @Route("/{id}/pagar", name="administracion_entidades_proveedor_pagar")
	 * @Template()
	 */
	public function pagarAction($id) {
		$em = $this->getDoctrine()->getEntityManager();

		$entity = $em->getRepository('GremioProveedoresBundle:Proveedor')
				->find($id);

		if (!$entity) {
			throw $this
					->createNotFoundException(
							'Unable to find Proveedor entity.');
		}
		$pagosPendientes = $em
				->getRepository('GremioAbmBundle:PagoAProveedor')
				->findPendientes($entity->getId());
		foreach ($pagosPendientes as $pago) {
			$pago->setPagado(true);
		}
		$em->flush();
		$this->get('session')
				->setFlash('succes', 'El Pago fue registrado Exitosamente');
		return $this
				->redirect(
						$this
								->generateUrl(
										'administracion_entidades_proveedor'));
	}

	/**
	 * Displays a form to create a new Proveedor entity.
	 *
	 * @Route("/new", name="administracion_entidades_proveedor_new")
	 * @Template()
	 */
	public function newAction() {
		$entity = new Proveedor();
		$form = $this->createForm(new ProveedorType(), $entity);

		return array('entity' => $entity, 'form' => $form->createView());
	}

	/**
	 * Creates a new Proveedor entity.
	 *
	 * @Route("/create", name="administracion_entidades_proveedor_create")
	 * @Method("post")
	 * @Template("GremioProveedoresBundle:Proveedor:new.html.twig")
	 */
	public function createAction() {
		$entity = new Proveedor();
		$request = $this->getRequest();
		$form = $this->createForm(new ProveedorType(), $entity);
		$form->bindRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getEntityManager();
			$entity->setEvento(true);
			$em->persist($entity);
			$em->flush();

			return $this
					->redirect(
							$this
									->generateUrl(
											'administracion_entidades_proveedor_show',
											array('id' => $entity->getId())));
		}

		return array('entity' => $entity, 'form' => $form->createView());
	}

	/**
	 * Displays a form to edit an existing Proveedor entity.
	 *
	 * @Route("/{id}/edit", name="administracion_entidades_proveedor_edit")
	 * @Template()
	 */
	public function editAction($id) {
		$em = $this->getDoctrine()->getEntityManager();

		$entity = $em->getRepository('GremioProveedoresBundle:Proveedor')
				->find($id);

		if (!$entity) {
			throw $this
					->createNotFoundException(
							'Unable to find Proveedor entity.');
		}

		$editForm = $this->createForm(new ProveedorType(), $entity);
		$deleteForm = $this->createDeleteForm($id);

		return array('entity' => $entity, 'form' => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),);
	}

	/**
	 * Edits an existing Proveedor entity.
	 *
	 * @Route("/{id}/update", name="administracion_entidades_proveedor_update")
	 * @Method("post")
	 * @Template("GremioProveedoresBundle:Proveedor:edit.html.twig")
	 */
	public function updateAction($id) {
		$em = $this->getDoctrine()->getEntityManager();

		$entity = $em->getRepository('GremioProveedoresBundle:Proveedor')
				->find($id);

		if (!$entity) {
			throw $this
					->createNotFoundException(
							'Unable to find Proveedor entity.');
		}

		$editForm = $this->createForm(new ProveedorType(), $entity);
		$deleteForm = $this->createDeleteForm($id);

		$request = $this->getRequest();

		$editForm->bindRequest($request);

		if ($editForm->isValid()) {
			$em->persist($entity);
			$em->flush();

			return $this
					->redirect(
							$this
									->generateUrl(
											'administracion_entidades_proveedor'));
		}

		return array('entity' => $entity,
				'edit_form' => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),);
	}

	/**
	 * Deletes a Proveedor entity.
	 *
	 * @Route("/{id}/delete", name="administracion_entidades_proveedor_delete")
	 * @Method("post")
	 */
	public function deleteAction($id) {
		$form = $this->createDeleteForm($id);
		$request = $this->getRequest();

		$form->bindRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getEntityManager();
			$entity = $em->getRepository('GremioProveedoresBundle:Proveedor')
					->find($id);

			if (!$entity) {
				throw $this
						->createNotFoundException(
								'Unable to find Proveedor entity.');
			}
			if ($entity->getFechaBaja()) {
				$entity->setFechaBaja(null);
				$entity->setUsuarioBaja(null);
			} else {
				$entity->setFechaBaja(new \DateTime());
				$entity
						->setUsuarioBaja(
								$this->get('security.context')->getToken()
										->getUser()->getUsername());
			}
			$em->flush();
		}

		return $this
				->redirect(
						$this
								->generateUrl(
										'administracion_entidades_proveedor'));
	}

	private function createDeleteForm($id) {
		return $this->createFormBuilder(array('id' => $id))
				->add('id', 'hidden')->getForm();
	}

}
