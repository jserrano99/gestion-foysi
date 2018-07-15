<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Proveedor;
use AppBundle\Form\ProveedorType;

class ProveedorController extends Controller {

    private $sesion;

    public function __construct() {
        $this->sesion = new Session();
    }

    public function queryAction() {
        $EM = $this->getDoctrine()->getManager();
        $Proveedor_repo = $EM->getRepository("AppBundle:Proveedor");
        $ProveedorAll = $Proveedor_repo->findAll();

        $params = array("proveedorAll" => $ProveedorAll);
        return $this->render("proveedor/query.html.twig", $params);
    }

    public function addAction(Request $request) {
        $EM = $this->getDoctrine()->getManager();
        $Proveedor = new Proveedor();
        $form = $this->createForm(ProveedorType::class, $Proveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $EM->persist($Proveedor);
            $EM->flush();
            $status = "Proveedor creado correctamente";
            $this->sesion->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("queryProveedor");
        }

        $params = array("accion" => "I",
            "proveedor" => $Proveedor,
            "form" => $form->createView());
        return $this->render("proveedor/update.html.twig", $params);
    }

    public function editAction(Request $request, $id) {
        $EM = $this->getDoctrine()->getManager();
        $Proveedor_repo = $EM->getRepository("AppBundle:Proveedor");
        $Proveedor = $Proveedor_repo->find($id);

        $form = $this->createForm(ProveedorType::class, $Proveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $EM->persist($Proveedor);
            $EM->flush();
            $status = "Proveedor modificado correctamente";
            $this->sesion->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("queryProveedor");
        }

        $params = array("accion" => "U",
            "proveedor" => $Proveedor,
            "form" => $form->createView());
        return $this->render("proveedor/update.html.twig", $params);
    }

    public function deleteAction($id) {
        $EM = $this->getDoctrine()->getManager();
        $Proveedor_repo = $EM->getRepository("AppBundle:Proveedor");
        $Proveedor = $Proveedor_repo->find($id);

        $EM->remove($Proveedor);
        $EM->flush();
        $status = "Proveedor eliminado correctamente";
        $this->sesion->getFlashBag()->add("status", $status);

        return $this->redirectToRoute("queryProveedor");
    }

}
