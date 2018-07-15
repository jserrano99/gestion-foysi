<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\lineaPedido;
use AppBundle\Form\LineaPedidoType;

class LineaPedidoController extends Controller {

	private $sesion;

	public function __construct() {
		$this->sesion = new Session();
	}

	public function addAction(Request $request, $pedido_id) {
		$EM = $this->getDoctrine()->getManager();
		$Pedido_repo = $EM->getRepository("AppBundle:Pedido");
		$Pedido = $Pedido_repo->find($pedido_id);
		$LineaPedido_repo = $EM->getRepository("AppBundle:LineaPedido");
		$LineaPedidoAll = $LineaPedido_repo->createQueryBuilder('u')
						->where("u.pedido = :pedido")
						->setParameter("pedido", $Pedido)
						->getQuery()->getResult();

		$LineaPedido = new LineaPedido();
		$form = $this->createForm(LineaPedidoType::class, $LineaPedido);
		$form->handleRequest($request);

		if ($form->isSubmitted()) {
			$LineaPedido->setPedido($Pedido);
			$LineaPedido->setImporteUnitario($LineaPedido->getServicio()->getImporteUnitario());
			$LineaPedido->setTotalServicio($LineaPedido->getImporteUnitario() * $LineaPedido->getUnidades());
			if ($Pedido->getDescuento()) {
				$LineaPedido->setDescuento($LineaPedido->getTotalServicio() * $Pedido->getDescuento()->getPorcentaje() / 100);
			} else {
				$LineaPedido->setDescuento(0);
			}
			$LineaPedido->setBaseImponible($LineaPedido->getTotalServicio() - $LineaPedido->getDescuento());
			$LineaPedido->setCuotaIVA($LineaPedido->getBaseImponible() * 0.21);
			$LineaPedido->setTotalLinea($LineaPedido->getBaseImponible() + $LineaPedido->getCuotaIVA());

			$EM->persist($LineaPedido);
			$EM->flush();
			$params = array("pedido_id" => $Pedido->getId());
			return $this->redirectToRoute("addLineaPedido", $params);
		}

		$params = array("pedido" => $Pedido,
			"lineaPedidoAll" => $LineaPedidoAll,
			"form" => $form->createView());
		return $this->render("lineaPedido/update.html.twig", $params);
	}

	public function deleteAction($id) {
		$EM = $this->getDoctrine()->getManager();
		$LineaPedido_repo = $EM->getRepository("AppBundle:LineaPedido");
		$LineaPedido = $LineaPedido_repo->find($id);
		$pedido_id = $LineaPedido->getPedido()->getId();
		$EM->remove($LineaPedido);
		$EM->flush();
		$params = array("pedido_id" => $pedido_id);
		return $this->redirectToRoute("addLineaPedido", $params);
	}

}
