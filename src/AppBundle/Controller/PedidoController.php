<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Pedido;
use AppBundle\Form\PedidoType;
use AppBundle\Reports\ImpresoPedido;
use AppBundle\Entity\Cliente;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

class PedidoController extends Controller {

    private $sesion;

    public function __construct() {
        $this->sesion = new Session();
    }

    public function queryAction(Request $request) {
        $isAjax = $request->isXmlHttpRequest();

        $datatable = $this->get('sg_datatables.factory')->create(\AppBundle\Datatables\PedidoDatatable::class);
        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService = $this->get('sg_datatables.response');
            $responseService->setDatatable($datatable);
            $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
            $datatableQueryBuilder->buildQuery();

            return $responseService->getResponse();
        }

        return $this->render('pedido/query.html.twig', array(
                    'datatable' => $datatable,
        ));
    }

    public function addAction(Request $request) {
        $EM = $this->getDoctrine()->getManager();
        $EstadoPedido_repo = $EM->getRepository("AppBundle:EstadoPedido");
        $Pedido = new Pedido($EstadoPedido_repo->find(1));

        $form = $this->createForm(PedidoType::class, $Pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->get('nombre')->getData() != null) {
                $Cliente = new Cliente();
                $Cliente->setNombre($form->get('nombre')->getData());
                $Cliente->setApenom($form->get('nombre')->getData());
                $Cliente->setNombreCompleto($form->get('nombre')->getData());
                $EM->persist($Cliente);
                $EM->flush();
                $Pedido->setCliente($Cliente);
            }
            if ($Pedido->getCliente()) {
                $obser = substr($form->get('observaciones')->getData(), 0, 254);
                $Pedido->setObservaciones($obser);
                $EM->persist($Pedido);
                $EM->flush();
                $params = array("pedido_id" => $Pedido->getId());
                return $this->redirectToRoute("addLineaPedido", $params);
            } else {
                $this->sesion->getFlashBag()->add("status", "ERROR CLIENTE O NOMBRE DEBE ESTAR INFORMADO ");
            }
        }

        $params = array("accion" => "NUEVO",
            "form" => $form->createView(),
            "pedido" => $Pedido);
        return $this->render("pedido/update.html.twig", $params);
    }

    public function editAction(Request $request, $id) {
        $EM = $this->getDoctrine()->getManager();
        $Pedido_repo = $EM->getRepository("AppBundle:Pedido");
        $Pedido = $Pedido_repo->find($id);

        $form = $this->createForm(PedidoType::class, $Pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->get('nombre')->getData() != null) {
                $Cliente = new Cliente();
                $Cliente->setNombre($form->get('nombre')->getData());
                $EM->persist($Cliente);
                $EM->flush();
                $Pedido->setCliente($Cliente);
            }
            $obser = substr($form->get('observaciones')->getData(), 0, 254);
            $Pedido->setObservaciones($obser);
            $EM->persist($Pedido);
            $EM->flush();
            $params = array("id" => $Pedido->getId());
            return $this->redirectToRoute("recalculoPedido", $params);
        }

        $params = array("accion" => "MODIFICACIÓN",
            "form" => $form->createView(),
            "pedido" => $Pedido);
        return $this->render("pedido/update.html.twig", $params);
    }

    public function deleteAction($id) {
        $EM = $this->getDoctrine()->getManager();
        $Pedido_repo = $EM->getRepository("AppBundle:Pedido");
        $Pedido = $Pedido_repo->find($id);
        try {
            $EM->remove($Pedido);
            $EM->flush();
            $status = "Pedido eliminado correctamente";
            $this->sesion->getFlashBag()->add("status", $status);
        } catch (ForeignKeyConstraintViolationException $ex) {
            $status = "No se puede eliminar el pedido tiene una factura asociada, elimina primero la factura";
            $this->sesion->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("queryPedido");
        } catch (\Doctrine\DBAL\DBALException $ex) {
            $status = $ex->getMessage();
            $this->sesion->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("queryPedido");
        }


        return $this->redirectToRoute("queryPedido");
    }

    public function imprimirAction($id) {
        $EM = $this->getDoctrine()->getManager();
        $Pedido_repo = $EM->getRepository("AppBundle:Pedido");
        $Pedido = $Pedido_repo->find($id);

        $pdf = new ImpresoPedido('P', 'mm', 'A4', $Pedido);

        return new Response($pdf->Output(), 200, array(
            'Content-Type' => 'application/pdf'));
    }

    public function recalculoAction($id) {
        $EM = $this->getDoctrine()->getManager();
        $Pedido_repo = $EM->getRepository("AppBundle:Pedido");
        $Pedido = $Pedido_repo->find($id);
        $LineaPedido_repo = $EM->getRepository("AppBundle:LineaPedido");
        $LineaPedidoALL = $LineaPedido_repo->createQueryBuilder('u')
                        ->where('u.pedido = :pedido')
                        ->setParameter('pedido', $Pedido)
                        ->getQuery()->getResult();
        foreach ($LineaPedidoALL as $linea) {
            $linea->setImporteUnitario($linea->getServicio()->getImporteUnitario());
            $linea->setTotalServicio($linea->getImporteUnitario() * $linea->getUnidades());
            if ($Pedido->getDescuento()) {
                $linea->setDescuento($linea->getTotalServicio() * $Pedido->getDescuento()->getPorcentaje() / 100);
            } else {
                $linea->setDescuento(0);
            }
            $linea->setBaseImponible($linea->getTotalServicio() - $linea->getDescuento());
            $linea->setCuotaIVA($linea->getBaseImponible()*$linea->getServicio()->getPorcentajeIVA());
            $linea->setTotalLinea($linea->getBaseImponible() + $linea->getCuotaIVA());
            $EM->persist($linea);
            $EM->flush();
        }
        return $this->redirectToRoute("addLineaPedido",array("pedido_id" => $id));
    }

}
