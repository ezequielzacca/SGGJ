<?php

namespace Gremio\ProveedoresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gremio\ProveedoresBundle\Entity\Proveedor;
use Gremio\ProveedoresBundle\Form\AutorizacionType;
use Gremio\SociosBundle\Entity\Emision;
use Gremio\SociosBundle\Entity\CuotaEmision;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Ps\PdfBundle\Annotation\Pdf;

/**
 * Proveedor controller.
 *
 * @Route("/proveedores")
 */
class ProveedoresController extends Controller {

	/**
	 * Lists all Proveedor entities.
	 *
	 * @Route("/", name="proveedores")
	 * @Template()
	 */
	public function indexAction() {
		$request = $this->getRequest();
		$proveedor = $this->get('security.context')->getToken()->getUser()
				->getProveedor();
		$form = $this->createForm(new AutorizacionType());
		/* if ($request->getMethod() == 'POST') {
		  $form->bindRequest($request);
		  if ($form->isValid()) {
		  $data = $form->getData();
		  $em = $this->getDoctrine()->getEntityManager();
		  $emision = $em->getRepository('GremioSociosBundle:Emision')->find($data['id']);
		  if (!$emision) {
		  $this->get('session')->setFlash('error', 'El Codigo ingresado no pertenece a ninguna emision');
		  return $this->redirect($this->generateUrl('proveedores'));
		  }
		  if (!$emision->getCodigoAprovacion()) {
		  if ($emision->getProveedor()->getId()==$proveedor->getId()) {
		  $emision->setCodigoAprovacion('1');
		  $em->flush();
		  $this->get('session')->setFlash('succes', 'La Emision fue Autorizada Correctamente');
		  return $this->redirect($this->generateUrl('proveedores'));
		  } else {
		  $this->get('session')->setFlash('error', 'La Emision no pertenece a este Proveedor');
		  return $this->redirect($this->generateUrl('proveedores'));
		  }
		  } else {
		  $this->get('session')->setFlash('error', 'La Emision ya fue autorizada previamente con el codigo ' . $this->get('my_util')->completar($data['id'], 9));
		  return $this->redirect($this->generateUrl('proveedores'));
		  }
		  }
		  } */
		return array('form' => $form->createView(),);
	}

	/**
	 * Lists all Proveedor entities.
	 *
	 * @Route("/emision/show/{codigo}", name="proveedores_emision", defaults={"codigo" = "-1"})
	 * @Template()
	 */
	public function emisionAction($codigo) {
		$request = $this->getRequest();
		//if ($request->isXmlHttpRequest()) {
		$id = substr($codigo, 0, 6);
		$legajo = substr($codigo, 6, 6);
		$fechaEmision = substr($codigo, 12, 8);
		$codigoProveedor = substr($codigo, 20, 4);
		$codigoTipoEmision = substr($codigo, 24, 2);

		$em = $this->getDoctrine()->getEntityManager();
		$emision = $em->getRepository('GremioSociosBundle:Emision')->find($id);
		$proveedor = $this->get('security.context')->getToken()->getUser()
				->getProveedor();
		if (!$emision) {
			$this->get('session')
					->setFlash('error',
							'El Codigo ingresado no pertenece a ninguna emision');
			return array('emision' => null);
		}
		if (!($emision->getSocio()->getLegajo() == $legajo)) {
			$this->get('session')
					->setFlash('error',
							'El Codigo ingresado no pertenece a ninguna emision');
			return array('emision' => null);
		} elseif (!($emision->getFechaEmision()->format("Ymd") == $fechaEmision)) {
			$this->get('session')
					->setFlash('error',
							'El Codigo ingresado no pertenece a ninguna emision');
			return array('emision' => null);
		} elseif (!($emision->getProveedor()->getId() == $codigoProveedor)) {
			$this->get('session')
					->setFlash('error',
							'El Codigo ingresado no pertenece a ninguna emision');
			return array('emision' => null);
		} elseif (!($emision->getTipoEmision()->getId() == $codigoTipoEmision)) {
			$this->get('session')
					->setFlash('error',
							'El Codigo ingresado no pertenece a ninguna emision');
			return array('emision' => null);
		} else {
			if (!$emision->getCodigoAprovacion()) {
				if ($emision->getProveedor()->getId() == $proveedor->getId()) {
					$form_autorizar = $this
							->createFormBuilder(array('id' => $id))
							->add('id', 'hidden')
							->add('importe', 'text',
									array('label' => 'Importe Final'))
							->add('cantidad_cuotas', 'text',
									array('label' => 'Cantidad de Cuotas'))
							->getForm();
					return array('emision' => $emision,
							'form' => $form_autorizar->createView());
				} else {
					$this->get('session')
							->setFlash('error',
									'La Emision no pertenece a este Proveedor');
					return array('emision' => null);
				}
			} else {
				$this->get('session')
						->setFlash('error',
								'La Emision ya fue autorizada previamente');
				return array('emision' => null);
			}
		}
		//} else {
		//    throw $this->createNotFoundException('No se encontro la Pagina Solicitada');
		// }
	}

	/**
	 * Retreives a ticket to autorize
	 *
	 * @Route("/autorizar/emision/{id}", name="autorizar_emision")
	 * @Template()
	 */
	public function autorizarAction($id) {
		$request = $this->getRequest();

		$form_autorizar = $this->createFormBuilder(array('id' => $id))
				->add('id', 'hidden')
				->add('importe', 'text', array('label' => 'Importe Final'))
				->add('cantidad_cuotas', 'text',
						array('label' => 'Cantidad de Cuotas'))->getForm();
		$form_autorizar->bindRequest($request);

		$cantidad_cuotas_ingresadas = $form_autorizar["cantidad_cuotas"]
				->getData();
		$importe_ingresado = $form_autorizar["importe"]->getData();
		;

		$em = $this->getDoctrine()->getEntityManager();
		$emision = $em->getRepository('GremioSociosBundle:Emision')->find($id);

		if ($emision->getImporte() >= $importe_ingresado) {
			$ahora = new \DateTime();
			$ahoraFormateado = $ahora->format('dmYhis');
			$codigoAprovacion = $emision->getId() . $ahora->format('dmYhis');
			$emision->setCodigoAprovacion($codigoAprovacion);
			$emision->setImporte($importe_ingresado);
			$emision->setCantidadCuotas($cantidad_cuotas_ingresadas);
			for ($i = 1; $i <= $emision->getCantidadCuotas(); $i++) {
				$ahora = new \DateTime();
				$cuota = new CuotaEmision();
				$cuota->setEmision($emision);
				$cuota->setProcesada(false);
				$cuota->setNumeroCuota($i);
				$mes = $ahora->format('n') + $i - 1;
				$anio = $ahora->format('Y');
				$cuota
						->setImporteCuota(
								round(
										$emision->getImporte()
												/ $emision->getCantidadCuotas()
												* 100) / 100);
				$fechaVencimiento = \DateTime::createFromFormat('d/n/Y',
						'01/' . $mes . '/' . $anio);
				$cuota->setFechaVencimiento($fechaVencimiento);
				$em->persist($cuota);
			}
			$em->flush();
			$this->get('session')
					->setFlash('succes',
							'La Emision fue Autorizada Correctamente con el codigo '
									. $codigoAprovacion);
			$this->get('session')->setFlash('id', $emision->getId());
			return $this->redirect($this->generateUrl('proveedores'));
		} else {
			$this->get('session')
					->setFlash('error',
							'El importe a Autorizar no puede ser mayor que el importe original de la emision');
		}

		return $this->redirect($this->generateUrl('proveedores'));
	}

	/**
	 * Retreives a ticket to autorize
	 *
	 * @Route("/imprimir/comprobante/{id}", name="imprimir_comprobante")
	 * @Template()
	 * @Pdf()
	 */
	public function imprimirComprobanteAction($id) {
		$em = $this->getDoctrine()->getEntityManager();
		$format = $this->getRequest()->get('_format');
		$emisiones = $em->getRepository('GremioSociosBundle:Emision')
				->findAutorizada($id);
		$emision = $emisiones[0];
		if ($emision) {
			return $this
					->render(
							sprintf(
									'GremioProveedoresBundle:Proveedores:imprimirComprobante.%s.twig',
									$format), array('emision' => $emision));
		} else
			return $this
					->createNotFoundException(
							'La emision solicitada no existe o no fue autorizada');
	}

	/**
	 * Muestra las emisiones autorizadas de este periodo
	 *
	 * @Route("/emisiones/autorizadas/", name="emisiones_autorizadas")
	 * @Template()
	 *
	 */
	public function emisionesAutorizadasAction() {
		$em = $this->getDoctrine()->getEntityManager();

		$emisiones = $em->getRepository('GremioSociosBundle:Emision')
				->findUltimasAutorizadas(
						$proveedor = $this->get('security.context')->getToken()
								->getUser()->getProveedor()->getId());
		return array('emisiones' => $emisiones);
	}

}
