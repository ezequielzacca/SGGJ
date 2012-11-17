<?php

namespace Gremio\AbmBundle\Controller;
use Symfony\Component\HttpFoundation\Response;

use Gremio\AbmBundle\Form\RetencionesType;
use Gremio\AbmBundle\Form\RetencionesComercioType;

use Symfony\Component\Security\Core\SecurityContext;

use Gremio\AbmBundle\Entity\Cierre;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gremio\AbmBundle\Entity\DetalleCierre;
use Gremio\SociosBundle\Entity\CuotaEmision;
use Gremio\AbmBundle\Entity\PagoAProveedor;
use Ps\PdfBundle\Annotation\Pdf;

/**
 * Cierre controller.
 *
 * @Route("/administracion/cierre")
 */
class CierreController extends Controller {

	/**
	 * Lista todos los cierres realizados
	 *
	 * @Route("/", name="administracion_cierres")
	 * @Template()
	 */
	public function indexAction() {

		$request = $this->get('request');
		$em = $this->getDoctrine()->getEntityManager();
		$cierres = $em->getRepository('GremioAbmBundle:Cierre')->findAll();
		return array('cierres' => $cierres);

	}

	/**
	 * Crea un nuevo lote de cierre
	 * Crea el movimiento de redondeo
	 *
	 * @Route("/nuevo", name="administracion_nuevo_cierre")
	 * @Template()
	 */
	public function nuevoCierreAction() {
		$periodo = $this->getRequest()->get('periodo');
		$em = $this->getDoctrine()->getEntityManager();
		$fechaTope = \DateTime::createFromFormat('dmY', '01' . $periodo);
		$lote = $em->getRepository('GremioAbmBundle:Cierre')
				->findByDescripcion($fechaTope->format('m/Y'));
		if ($lote) {
			$this->get('session')
					->setFlash('error',
							'El lote de Cierre ya fue generado anteriormente');
			return $this
					->redirect($this->generateUrl('administracion_cierres'));
		}
		$lote = new Cierre();
		$lote->setDescripcion($fechaTope->format('m/Y'));
		$lote->setFechaAlta(new \DateTime());
		$lote
				->setUsuarioAlta(
						$this->get('security.context')->getToken()
								->getUsername());

		$em->persist($lote);
		$reparticiones = $em->getRepository('GremioAbmBundle:Reparticion')
				->findAll();
		foreach ($reparticiones as $reparticion) {
			$cuotas = $em->getRepository('GremioSociosBundle:CuotaEmision')
					->findLotePeriodo($fechaTope, $reparticion->getId());
			$movimientoPositivo = new DetalleCierre();
			$movimientoPositivo->setCierre($lote);
			$movimientoPositivo->setReparticion($reparticion);
			if ($reparticion->getRedondeo())
				$movimientoPositivo
						->setImporteCuota($reparticion->getRedondeo());
			else
				$movimientoPositivo->setImporteCuota(0);
			$movimientoPositivo->setTipoDetalle('RA');//Redondeo Mes Anterior
			$em->persist($movimientoPositivo);
			$importeNuevo = $em
					->getRepository('GremioSociosBundle:CuotaEmision')
					->findImportePeriodo($fechaTope, $reparticion->getId());
			$importeNuevo = $importeNuevo[0];
			$importeNuevo = $importeNuevo + $reparticion->getRedondeo();
			$redondeoNuevo = $importeNuevo - intval($importeNuevo);
			$movimientoNegativo = new DetalleCierre();
			$movimientoNegativo->setCierre($lote);
			$movimientoNegativo->setReparticion($reparticion);
			$movimientoNegativo->setImporteCuota($redondeoNuevo);
			$movimientoNegativo->setTipoDetalle('R');//Redondeo Mes Actual
			$em->persist($movimientoNegativo);
			$reparticion->setRedondeo($redondeoNuevo);
			$cuotas = $em->getRepository('GremioSociosBundle:CuotaEmision')
					->findLotePeriodo($fechaTope, $reparticion->getId());
			foreach ($cuotas as $movimiento) {
				$movimientoCuota = new DetalleCierre();
				$movimientoCuota->setCierre($lote);
				$movimientoCuota->setCuota($movimiento);
				$movimientoCuota
						->setImporteCuota($movimiento->getImporteCuota());
				$movimientoCuota
						->setSocio($movimiento->getEmision()->getSocio());
				$movimientoCuota->setReparticion($reparticion);
				$movimientoCuota->setTipoDetalle('C');//Cuota
				$em->persist($movimientoCuota);
			}
			$em->flush();
			$proveedores = $em
					->getRepository('GremioProveedoresBundle:Proveedor')
					->findAll();
			foreach ($proveedores as $proveedor) {
				$pagoaproveedor = new PagoAProveedor();
				$pagoaproveedor->setCierre($lote);
				$pagoaproveedor->setProveedor($proveedor);
				$pagoaproveedor->setPagado(false);
				$importe = $em->getRepository('GremioAbmBundle:DetalleCierre')
						->findImportePago($lote, $proveedor->getId());
				$pagoaproveedor->setImporte($importe);
				$em->persist($pagoaproveedor);
			}

			//$movimiento->setProcesada(true);
			//$movimiento->setFechaProceso(new \DateTime());*/
			$em->flush();
			$this->get('session')
					->setFlash('succes',
							'El lote de Cierre fue generado correctamente');
			return $this
					->redirect($this->generateUrl('administracion_cierres'));

		}
	}

	/*
	 * Planilla de reparticiones: La pantalla deberá contar con un campo que permita 
	 * seleccionar una repartición y un combo que permita seleccionar el 
	 * ordenamiento del mismo, que podrá ser: por legajo, numero de documento o alfabético. 
	 * Los modelos de reporte de referencia en las hojas de ejemplo con 6.2.
	 */

	/**
	 * Reporte de Retenciones a Socios por reparticion
	 *
	 * @Route("/retenciones/reparticion/{lote}", name="administracion_cierres_retenciones")
	 * @Template()
	 * @Pdf()
	 */
	public function retencionesReparticionAction($lote) {

		$request = $this->get('request');
		$format = $request->get('_format');

		$em = $this->getDoctrine()->getEntityManager();
		$cierre = $em->getRepository('GremioAbmBundle:Cierre')->find($lote);
		$defaultData = array();
		$formRetenciones = $this
				->createForm(new RetencionesType(), $defaultData);
		if ($request->getMethod() == 'POST') {
			$formRetenciones->bindRequest($request);

			// data is an array with "name", "email", and "message" keys
			$data = $formRetenciones->getData();

			$seccion = $data['secciones'];
			$reparticion = $data['reparticiones'];
			$ordenamiento = $data['ordenamiento'];

			$detalles = $em->getRepository('GremioAbmBundle:DetalleCierre')
					->findRetenciones($lote, $reparticion->getId(),
							$ordenamiento, $seccion);

			$response = new Response();
			$response->headers->set('Content-type', 'application/pdf');
			$response->headers
					->set('Content-Disposition',
							'attachment; filename="retenciones'
									. $this->get('my_util')
											->slugify(
													$reparticion
															->getDescripcion())
									. '.pdf"');

			return $this
					->render(
							sprintf(
									'GremioAbmBundle:Cierre:retenciones.%s.twig',
									$format),
							array('detalles' => $detalles,
									'reparticion' => $reparticion
											->getDescripcion(),
									'seccion' => $seccion, 'cierre' => $cierre,),
							$response);
		}

	}

	/**
	 * Reporte de Retenciones a Socios por comercio
	 *
	 * @Route("/retenciones/comercio/{lote}", name="administracion_cierres_comercios")
	 * @Template()
	 * @Pdf()
	 */
	public function retencionesComercioAction($lote) {

		$request = $this->get('request');
		$format = $request->get('_format');

		$em = $this->getDoctrine()->getEntityManager();
		$cierre = $em->getRepository('GremioAbmBundle:Cierre')->find($lote);
		$defaultData = array();
		$formRetenciones = $this
				->createForm(new RetencionesComercioType(), $defaultData);
		if ($request->getMethod() == 'POST') {
			$formRetenciones->bindRequest($request);

			// data is an array with "name", "email", and "message" keys
			$data = $formRetenciones->getData();

			$comercio = $data['proveedor'];
			$rubro = $data['rubro'];
			$response = new Response();
			if ($comercio) {
				$detalles = $em->getRepository('GremioAbmBundle:DetalleCierre')
						->findRetencionesComercio($lote, $comercio->getId(),
								$rubro->getId());
				$response->headers
						->set('Content-Disposition',
								'attachment; filename="retenciones-'
										. $this->get('my_util')
												->slugify(
														$comercio
																->getRazonSocial())
										. '.pdf"');
			} else {
				$detalles = $em->getRepository('GremioAbmBundle:DetalleCierre')
						->findRetencionesComercio($lote, null, $rubro->getId());
				$response->headers
						->set('Content-Disposition',
								'attachment; filename="retenciones-rubro-'
										. $this->get('my_util')
												->slugify(
														$rubro
																->getDescripcion())
										. '.pdf"');
			}

			$response->headers->set('Content-type', 'application/pdf');

			return $this
					->render(
							sprintf(
									'GremioAbmBundle:Cierre:retencionesComercio.%s.twig',
									$format),
							array('detalles' => $detalles, 'cierre' => $cierre,),
							$response);
		}

	}

	/**
	 * Lista los reportes que pueden imprimirse de un lote
	 *
	 * @Route("/panel/{lote}", name="administracion_cierres_panel")
	 * @Template()
	 * @Pdf()
	 */
	public function panelAction($lote) {

		$request = $this->getRequest();

		$em = $this->getDoctrine()->getEntityManager();
		$cierre = $em->getRepository('GremioAbmBundle:Cierre')->find($lote);
		$defaultData = array();
		$defaultDataComercio = array();
		$formRetenciones = $this
				->createForm(new RetencionesType(), $defaultData);
		$formRetencionesComercio = $this
				->createForm(new RetencionesComercioType(),
						$defaultDataComercio);

		return array('lote' => $cierre,
				'form_retenciones' => $formRetenciones->createView(),
				'form_comercio' => $formRetencionesComercio->createView(),);

	}

}
