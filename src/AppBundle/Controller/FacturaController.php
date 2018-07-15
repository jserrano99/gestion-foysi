<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Factura;
use AppBundle\Reports\ImpresoFactura;

class FacturaController extends Controller {

    private $sesion;

    public function __construct() {
        $this->sesion = new Session();
    }

    public function queryAction() {
        $EM = $this->getDoctrine()->getManager();
        $Factura_repo = $EM->getRepository("AppBundle:Factura");
        $FacturaAll = $Factura_repo->findAll();

        $params = array("facturaAll" => $FacturaAll);
        return $this->render("factura/query.html.twig", $params);
    }

    public function generarAction($pedido_id) {
        $EM = $this->getDoctrine()->getManager();
        $Pedido_repo = $EM->getRepository("AppBundle:Pedido");
        $Pedido = $Pedido_repo->find($pedido_id);
        if ($Pedido->getCliente()->getNif() == null) {
            $status = "ERROR COMPLETAR LOS DATOS DEL CLIENTE "
                    . $Pedido->getCliente()->getNombreCompleto()
                    . " PARA EMITIR LA FACTURA";
            $this->sesion->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("queryPedido");
        }
        if ($Pedido->getRecibo() != null) {
            $status = "ERROR YA SE HABÍA EMITIDO RECIBO DE ESTE PEDIDO, ELIMINARLO ANTES DE GENERAR FACTURA ";
            $this->sesion->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("queryPedido");
        }
        
        if ($Pedido->getFactura() != null) {
            $params = array("id" => $Pedido->getFactura()->getId());
        } else {
            $Factura = new Factura();
            $sigNumero = $this->siguienteNumero(2018);
            $Factura->setFecha($Pedido->getFecha());
            $Factura->setPedido($Pedido);
            $Factura->setEjercicio($Pedido->getFecha()->format('Y'));
            $Factura->setNumero($sigNumero);
            $EM->persist($Factura);
            $EM->flush();
            $params = array("id" => $Factura->getId());
        }
        return $this->redirectToRoute("imprimirFactura", $params);
    }

    public function imprimirAction($id) {
        $EM = $this->getDoctrine()->getManager();
        $Factura_repo = $EM->getRepository("AppBundle:Factura");
        $Factura = $Factura_repo->find($id);

        $pdf = new ImpresoFactura('P', 'mm', 'A4', $Factura);

        return new Response($pdf->Output(), 200, array(
            'Content-Type' => 'application/pdf'));
    }

    public function siguienteNumero($ejercicio) {
        $EM = $this->getDoctrine()->getManager();
        $Factura_repo = $EM->getRepository("AppBundle:Factura");
        $UltimaFactura = $Factura_repo->createQueryBuilder('u')
                        ->select('max(u.numero) as ultimo')
                        ->where('u.ejercicio = :ejercicio')
                        ->setParameter('ejercicio', $ejercicio)
                        ->getQuery()->getResult();

        $numero = $UltimaFactura[0]['ultimo'];
        if ($numero == null) {
            return 1;
        } else {
            return $numero + 1;
        }
    }

    public function deleteAction($id) {
        $EM = $this->getDoctrine()->getManager();
        $Factura_repo = $EM->getRepository("AppBundle:Factura");
        $Factura = $Factura_repo->find($id);
        $status = " Factura " . $Factura->getNumero() . '/' . $Factura->getEjercicio() . " Eliminada Correctamente";
        $EM->remove($Factura);
        $EM->flush();
        $this->sesion->getFlashBag()->add("status", $status);
        return $this->redirectToRoute("queryFactura");
    }

}
