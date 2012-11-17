<?php

namespace Gremio\AbmBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gremio\AbmBundle\Entity\Localidad;
use Gremio\AbmBundle\Form\LocalidadType;
use Ps\PdfBundle\Annotation\Pdf;
use Symfony\Component\HttpFoundation\Response;

/**
 * Consultas controller.
 *
 * @Route("/administracion/consultas")
 */
class ConsultasController extends Controller {
	/**
	 * Lista todas las emisiones realizadas entre dos fechas.
	 *
	 * @Route("/emisiones/emitidas/ayax/", name="administracion_consultas_emisiones_emitidas_ayax")
	 * @Template()
	 * @Pdf()
	 */
	public function emisionesEmitidasAction() {

		$em = $this->getDoctrine()->getEntityManager();
		$request = $this->getRequest();

		$fechaDesde = $request->get('fechaDesde');
		$fechaHasta = $request->get('fechaHasta');
		$format = $request->get('_format');
		$desde = \DateTime::createFromFormat('dmY H:i:s',
				$fechaDesde . ' 00:00:00');
		$hasta = \DateTime::createFromFormat('dmY H:i:s',
				$fechaHasta . ' 23:59:59');
		$entities = $em->getRepository('GremioSociosBundle:Emision')
				->findEmitidas($desde, $hasta);
		
		$cantidadCompras = $em->getRepository('GremioSociosBundle:Emision')
				->findCantidadEmitidas($desde, $hasta,"Vale de Compras");
		
		$cantidadCombustible = $em->getRepository('GremioSociosBundle:Emision')
				->findCantidadEmitidas($desde, $hasta, "Vale de Combustible");
		$cantidadEvento = $em->getRepository('GremioSociosBundle:Emision')
				->findCantidadEmitidas($desde, $hasta, "Evento");
		$cantidadPrestamo = $em->getRepository('GremioSociosBundle:Emision')
				->findCantidadEmitidas($desde, $hasta, "Prestamo");
		$cantidadPasaje = $em->getRepository('GremioSociosBundle:Emision')
				->findCantidadEmitidas($desde, $hasta, "Orden de Pasajes");
		if ($request->isXmlHttpRequest()) {
			return array('entities' => $entities, 'fecha_desde' => $desde,
					'fecha_hasta' => $hasta,
					'cantidad_compra' => $cantidadCompras,
					'cantidad_combustible' => $cantidadCombustible,
					'cantidad_evento' => $cantidadEvento,
					'cantidad_prestamo' => $cantidadPrestamo,
					'cantidad_pasaje' => $cantidadPasaje);

		} else if ($format == 'pdf') {
			$response = new Response();
			$response->headers->set('Content-type', 'application/pdf');
			$response->headers
					->set('Content-Disposition',
							'attachment; filename="consulta-emisiones-emitidas-desde-'
									. $fechaDesde . '-hasta-' . $fechaHasta
									. '.pdf"');
			return $this
					->render(
							sprintf(
									'GremioAbmBundle:Consultas:emisionesEmitidas.%s.twig',
									$format),
							array('entities' => $entities,
									'fecha_desde' => $desde,
									'fecha_hasta' => $hasta), $response);
		}
	}

	/**
	 * Lista todas las emisiones realizadas entre dos fechas.
	 *
	 * @Route("/emisiones/anuladas/ayax/", name="administracion_consultas_emisiones_anuladas_ayax")
	 * @Template()
	 * @Pdf()
	 */
	public function emisionesAnuladasAction() {
		$em = $this->getDoctrine()->getEntityManager();
		$request = $this->getRequest();

		$fechaDesde = $request->get('fechaDesde');
		$fechaHasta = $request->get('fechaHasta');
		$format = $request->get('_format');
		$desde = \DateTime::createFromFormat('dmY H:i:s',
				$fechaDesde . ' 00:00:00');
		$hasta = \DateTime::createFromFormat('dmY H:i:s',
				$fechaHasta . ' 23:59:59');
		$entities = $em->getRepository('GremioSociosBundle:Emision')
				->findAnuladas($desde, $hasta);
		$cantidadCompras = $em->getRepository('GremioSociosBundle:Emision')
		->findCantidadAnuladas($desde, $hasta,"Vale de Compras");
		
		$cantidadCombustible = $em->getRepository('GremioSociosBundle:Emision')
		->findCantidadAnuladas($desde, $hasta, "Vale de Combustible");
		$cantidadEvento = $em->getRepository('GremioSociosBundle:Emision')
		->findCantidadAnuladas($desde, $hasta, "Evento");
		$cantidadPrestamo = $em->getRepository('GremioSociosBundle:Emision')
		->findCantidadAnuladas($desde, $hasta, "Prestamo");
		$cantidadPasaje = $em->getRepository('GremioSociosBundle:Emision')
		->findCantidadAnuladas($desde, $hasta, "Orden de Pasajes");
		if ($request->isXmlHttpRequest()) {
			return array('entities' => $entities, 'fecha_desde' => $desde,
					'fecha_hasta' => $hasta,
					'cantidad_compra' => $cantidadCompras,
					'cantidad_combustible' => $cantidadCombustible,
					'cantidad_evento' => $cantidadEvento,
					'cantidad_prestamo' => $cantidadPrestamo,
					'cantidad_pasaje' => $cantidadPasaje);
		} else if ($format == 'pdf') {
			$response = new Response();
			$response->headers->set('Content-type', 'application/pdf');
			$response->headers
					->set('Content-Disposition',
							'attachment; filename="consulta-emisiones-anuladas-desde-'
									. $fechaDesde . '-hasta-' . $fechaHasta
									. '.pdf"');
			return $this
					->render(
							sprintf(
									'GremioAbmBundle:Consultas:emisionesAnuladas.%s.twig',
									$format),
							array('entities' => $entities,
									'fecha_desde' => $desde,
									'fecha_hasta' => $hasta), $response);
		}
	}
	/**
	 * 
	 *
	 * @Route("/pago/proveedores/", name="administracion_consultas_pago_a_proveedores")
	 * @Template()
	 * @Pdf()
	 */
	public function pagoAProveedoresAction() {
		$em = $this->getDoctrine()->getEntityManager();
		$request = $this->getRequest();
		$format = $request->get('_format');
		$response = new Response();
		$response->headers->set('Content-type', 'application/pdf');
		$response->headers
				->set('Content-Disposition',
						'attachment; filename="consulta-pagos-pendientes-a-proveedores.pdf"');
		$pagosPendientes = $em->getRepository('GremioAbmBundle:PagoAProveedor')
				->findPendientes();

		return $this
				->render(
						sprintf(
								'GremioAbmBundle:Consultas:pagoAProveedores.%s.twig',
								$format), array('pagos' => $pagosPendientes),
						$response);
	}
	/**
	 * 
	 *
	 * @Route("/emisiones/anuladas/", name="administracion_consultas_emisiones_anuladas")
	 * @Template()
	 */
	public function consultaEmisionesAnuladasAction() {
		return array();
	}

	/**
	 *
	 *
	 * @Route("/emisiones/emitidas/", name="administracion_consultas_emisiones_emitidas")
	 * @Template()
	 */
	public function consultaEmisionesEmitidasAction() {
		return array();
	}
}
