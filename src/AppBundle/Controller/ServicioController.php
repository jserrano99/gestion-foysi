<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Servicio;
use AppBundle\Form\ServicioType;

class ServicioController extends Controller {

	private $sesion;

	public function __construct() {
		$this->sesion = new Session();
	}

	public function queryAction(Request $request) {
		$isAjax = $request->isXmlHttpRequest();

		$datatable = $this->get('sg_datatables.factory')->create(\AppBundle\Datatables\ServicioDatatable::class);
		$datatable->buildDatatable();

		if ($isAjax) {
			$responseService = $this->get('sg_datatables.response');
			$responseService->setDatatable($datatable);
			$datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
			$datatableQueryBuilder->buildQuery();

			return $responseService->getResponse();
		}

		return $this->render('servicio/query.html.twig', array(
					'datatable' => $datatable,
		));
	}

	public function addAction(Request $request) {
		$EM = $this->getDoctrine()->getManager();
		$Servicio = new Servicio();
		$form = $this->createForm(ServicioType::class, $Servicio);
		$form->handleRequest($request);

		if ($form->isSubmitted()) {
			$EM->persist($Servicio);
			$EM->flush();
			$status = "Servicio creado correctamente";
			$this->sesion->getFlashBag()->add("status", $status);
			return $this->redirectToRoute("queryServicio");
		}

		$params = array("accion" => "NUEVO",
			"servicio" => $Servicio,
			"form" => $form->createView());
		return $this->render("servicio/edit.html.twig", $params);
	}

	public function editAction(Request $request, $id) {
		$EM = $this->getDoctrine()->getManager();
		$Servicio_repo = $EM->getRepository("AppBundle:Servicio");
		$Servicio = $Servicio_repo->find($id);

		$form = $this->createForm(ServicioType::class, $Servicio);
		$form->handleRequest($request);

		if ($form->isSubmitted()) {
			$EM->persist($Servicio);
			$EM->flush();
			$status = "Servicio modificado correctamente";
			$this->sesion->getFlashBag()->add("status", $status);
			return $this->redirectToRoute("queryServicio");
		}

		$params = array("accion" => "MODIFICACIÓN",
			"servicio" => $Servicio,
			"form" => $form->createView());
		return $this->render("servicio/edit.html.twig", $params);
	}

	public function deleteAction($id) {
		$EM = $this->getDoctrine()->getManager();
		$Servicio_repo = $EM->getRepository("AppBundle:Servicio");
		$Servicio = $Servicio_repo->find($id);

		$EM->remove($Servicio);
		$EM->flush();
		$status = "Servicio eliminado correctamente";
		$this->sesion->getFlashBag()->add("status", $status);

		return $this->redirectToRoute("queryServicio");
	}

}
