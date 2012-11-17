<?php

namespace Gremio\SociosBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gremio\SociosBundle\Entity\Emision;
use Gremio\SociosBundle\Form\GeneraCompraType;
use Gremio\SociosBundle\Form\GeneraCombustibleType;
use Gremio\SociosBundle\Form\GeneraPasajeType;
use Gremio\SociosBundle\Form\GeneraPrestamoType;
use Gremio\SociosBundle\Form\GeneraEventoType;
use Gremio\SociosBundle\Entity\TipoEmision;
use Ps\PdfBundle\Annotation\Pdf;

/**
 * @Route("/panel")
 * 
 */
class SociosController extends Controller {

	/**
	 * @Route("/bienvenida", name="socio_panel")
	 * 
	 * @Template()
	 */
	public function indexAction() {
		$usuario = $this->get('security.context')->getToken()->getUser();
		$em = $this->getDoctrine()->getEntityManager();

		$emisiones = $em->getRepository('GremioSociosBundle:Emision')
				->findUltimasDelSocio($usuario->getId());

		$margen = $this->get('my_util')->getMargen($usuario);

		/****************************************/

		$emision = new Emision();

		$formcompra = $this->createForm(new GeneraCompraType(), $emision);
		$formcombustible = $this
				->createForm(new GeneraCombustibleType(), $emision);
		$formpasaje = $this->createForm(new GeneraPasajeType(), $emision);
		$formprestamo = $this->createForm(new GeneraPrestamoType(), $emision);
		$formevento = $this->createForm(new GeneraEventoType(), $emision);

		return array('emisiones' => $emisiones, 'margen' => $margen,
				'form_compra' => $formcompra->createView(),
				'form_combustible' => $formcombustible->createView(),
				'form_pasajes' => $formpasaje->createView(),
				'form_prestamo' => $formprestamo->createView(),
				'entity' => $usuario,);
	}

	/**
	 * @Route("/generar/emision/{tipo}", requirements={"tipo"="compra|combustible|prestamo|pasajes|evento"}, defaults={"tipo"="compra"} , name="generar_emision")
	 * @Route("/generar/emision/")
	 * @Template()
	 */
	public function generarEmisionAction($tipo = null) {

		//$tipo_emision = $request->getQueryString('tipo_emision');
		$peticion = $this->getRequest();
		$em = $this->getDoctrine()->getEntityManager();

		$usuario = $this->get('security.context')->getToken()->getUser();
		$margen = $this->get('my_util')->getMargen($usuario);

		$emision = new Emision();

		$formcompra = $this->createForm(new GeneraCompraType(), $emision);
		$formcombustible = $this
				->createForm(new GeneraCombustibleType(), $emision);
		$formpasaje = $this->createForm(new GeneraPasajeType(), $emision);
		$formprestamo = $this->createForm(new GeneraPrestamoType(), $emision);
		$formevento = $this->createForm(new GeneraEventoType(), $emision);

		if ($peticion->getMethod() == 'POST') {

			$emision
					->setUsuarioEmision(
							$this->get('security.context')->getToken()
									->getUser()->getUsername());
			$emision->setSocio($usuario);

			$emision->setFechaEmision(new \DateTime());
			$fechaValidez = date_create(date('Ym01'))
					->modify('+1 month -1 day');
			$emision->setFechaValidez($fechaValidez);
			if ($tipo == 'compra') {
				$formcompra->bindRequest($peticion);
				if ($formcompra->isValid()) {

					$consulta = $em
							->createQuery(
									'SELECT e from GremioSociosBundle:TipoEmision e  
                                        WHERE e.descripcion=?1');
					$consulta->setParameter(1, 'Vale de Compras');
					$tipoemision = $consulta->getSingleResult();
					$emision->setTipoEmision($tipoemision);
					if ($emision->getImporte() <= $usuario->getMargen()) {
						$em->persist($emision);

						$em->flush();
						$this->get('session')
								->setFlash('info',
										'La Orden de Compra fue generada correctamente');
						return $this
								->redirect($this->generateUrl('socio_panel'));
					} else {
						$this->get('session')
								->setFlash('error-compra',
										'El importe ingresado es mayor que el margen disponible');
					}
				}
			} else if ($tipo == 'pasajes') {
				$formpasaje->bindRequest($peticion);
				if ($formpasaje->isValid()) {
					$emision->setCantidadCuotas(1);
					$em = $this->getDoctrine()->getEntityManager();
					$consulta = $em
							->createQuery(
									'SELECT e from GremioSociosBundle:TipoEmision e  
                                        WHERE e.descripcion=?1');
					$consulta->setParameter(1, 'Orden de Pasajes');
					$tipoemision = $consulta->getSingleResult();
					$emision->setTipoEmision($tipoemision);
					if ($emision->getImporte() <= $usuario->getMargen()) {
						$em->persist($emision);

						$em->flush();
						$this->get('session')
								->setFlash('info',
										'La Orden de Pasajes fue generada correctamente');
						return $this
								->redirect($this->generateUrl('socio_panel'));
					} else {
						$this->get('session')
								->setFlash('error-pasajes',
										'El importe ingresado es mayor que el margen disponible');
					}
				}
			} else if ($tipo == 'combustible') {
				$formcombustible->bindRequest($peticion);
				if ($formcombustible->isValid()) {
					$emision->setCantidadCuotas(1);
					$em = $this->getDoctrine()->getEntityManager();
					$consulta = $em
							->createQuery(
									'SELECT e from GremioSociosBundle:TipoEmision e  
                                        WHERE e.descripcion=?1');
					$consulta->setParameter(1, 'Vale de Combustible');
					$tipoemision = $consulta->getSingleResult();
					$emision->setTipoEmision($tipoemision);
					if ($emision->getImporte() <= $usuario->getMargen()) {
						$em->persist($emision);

						$em->flush();
						$this->get('session')
								->setFlash('info',
										'La Orden de Carga de Combustible fue generada correctamente');
						return $this
								->redirect($this->generateUrl('socio_panel'));
					} else {
						$this->get('session')
								->setFlash('error-combustible',
										'El importe ingresado es mayor que el margen disponible');
					}
				}
			} else if ($tipo == 'prestamo') {
				$formprestamo->bindRequest($peticion);
				if ($formprestamo->isValid()) {

					$emision->setCantidadCuotas(1);
					$em = $this->getDoctrine()->getEntityManager();
					$consulta = $em
							->createQuery(
									'SELECT e from GremioSociosBundle:TipoEmision e  
                                        WHERE e.descripcion=?1');
					$consulta->setParameter(1, 'Prestamo');
					$tipoemision = $consulta->getSingleResult();
					$emision->setTipoEmision($tipoemision);
					if ($emision->getImporte() <= $usuario->getMargen()) {
						$em->persist($emision);

						$em->flush();
						$this->get('session')
								->setFlash('info',
										'La Orden de Prestamo fue generada correctamente');
						return $this
								->redirect($this->generateUrl('socio_panel'));
					} else {
						$this->get('session')
								->setFlash('error-prestamo',
										'El importe ingresado es mayor que el margen disponible');
					}
				}
			}
		}

		return array('form_compra' => $formcompra->createView(),
				'form_combustible' => $formcombustible->createView(),
				'form_pasajes' => $formpasaje->createView(),
				'form_prestamo' => $formprestamo->createView(),
				'entity' => $usuario, 'margen' => $margen,);
	}

	/**
	 * @Route("/emision/imprimir/{id}/", name="imprimir_emision")
	 * 
	 * @Template()
	 * @Pdf()
	 */
	public function imprimirEmisionAction($id) {
		$em = $this->getDoctrine()->getEntityManager();
		$format = $this->get('request')->get('_format');
		$emision = $em->getRepository('GremioSociosBundle:Emision')->find($id);

		return $this
				->render(
						sprintf(
								'GremioSociosBundle:Socios:imprimirEmision.%s.twig',
								$format), array('emision' => $emision));
	}

	/**
	 * @Route("/anular/emision/{id}", name="anular_emision")
	 * 
	 * @Template()
	 */
	public function anularEmisionAction($id) {
		$em = $this->getDoctrine()->getEntityManager();
		$emision = $em->getRepository('GremioSociosBundle:Emision')->find($id);
		if (!$emision->getCodigoAprovacion()) {
			$emision->setFechaAnulacion(new \DateTime());
			$emision
					->setUsuarioAnulacion(
							$this->get('security.context')->getToken()
									->getUser()->getUserName());
			$em->flush();
			$this->get('session')
					->setFlash('info', 'La Emision fue anulada correctamente');
			$this->get('session')
					->setFlash('succes', 'La Emision fue anulada correctamente');
		} else {
			$this->get('session')
					->setFlash('error',
							'No puede anularse una emision que ya fue aprobada');
		}
		if ($this->get('security.context')->isGranted('ROLE_SOCIO'))
			return $this->redirect($this->generateUrl('socio_panel'));
		else
			return $this
					->redirect(
							$this
									->generateUrl('socio_show',
											array(
													'id' => $emision
															->getSocio()
															->getId())));

	}

}
