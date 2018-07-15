<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Cliente;
use AppBundle\Form\ClienteType;


class ClienteController extends Controller {

    private $sesion;

    public function __construct() {
        $this->sesion = new Session();
    }

    public function esDniValido($dni) {
        // Comprobar que el formato sea correcto
        if (0 === preg_match("/\d{1,8}[a-z]/i", $dni)) {
            $status = 'El DNI introducido no tiene el formato correcto '
                    . ' (entre 1 y 8 números seguidos de una letra, sin guiones '
                    . ' y sin dejar ningún espacio en blanco)';
            $this->sesion->getFlashBag()->add("status", $status);
            return false;
        }

        // Comprobar que la letra cumple con el algoritmo
        $numero = substr($dni, 0, -1);
        $letra = strtoupper(substr($dni, -1));
        if ($letra != substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($numero, "XYZ", "012") % 23, 1)) {
            $status = 'La letra no coincide con el número del DNI. '
                    . ' Comprueba que has escrito bien tanto el número como la letra';
            $this->sesion->getFlashBag()->add("status", $status);
            return false;
        }
        return true;
    }

    public function queryAction() {
        $EM = $this->getDoctrine()->getManager();
        $Cliente_repo = $EM->getRepository("AppBundle:Cliente");
        $ClienteAll = $Cliente_repo->findAll();

        $params = array("clienteAll" => $ClienteAll);
        return $this->render("cliente/query.html.twig", $params);
    }

    public function addAction(Request $request) {
        $EM = $this->getDoctrine()->getManager();
        $Cliente = new Cliente();
        $form = $this->createForm(ClienteType::class, $Cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($this->esDniValido($form->get('nif')->getData())) {
                try {
                    $EM->persist($Cliente);
                    $EM->flush();
                    $status = "Cliente creado correctamente";
                    $this->sesion->getFlashBag()->add("status", $status);
                } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $ex ){
                    $status = " YA EXISTE UN CLIENTE CON ESTE NIF ";
                    $this->sesion->getFlashBag()->add("status", $status);
                } catch (\Doctrine\DBAL\DBALException $ex){
                    $status = $ex->getMessage();
                    $this->sesion->getFlashBag()->add("status", $status);
                }
                return $this->redirectToRoute("queryCliente");
            }
        }

        $params = array("accion" => "I",
            "cliente" => $Cliente,
            "form" => $form->createView());
        return $this->render("cliente/update.html.twig", $params);
    }

    public function editAction(Request $request, $id) {
        $EM = $this->getDoctrine()->getManager();
        $Cliente_repo = $EM->getRepository("AppBundle:Cliente");
        $Cliente = $Cliente_repo->find($id);

        $form = $this->createForm(ClienteType::class, $Cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($this->esDniValido($form->get('nif')->getData())) {
                $EM->persist($Cliente);
                $EM->flush();
                $status = "Cliente modificado correctamente";
                $this->sesion->getFlashBag()->add("status", $status);
                return $this->redirectToRoute("queryCliente");
            }
        }

        $params = array("accion" => "U",
            "cliente" => $Cliente,
            "form" => $form->createView());
        return $this->render("cliente/update.html.twig", $params);
    }

    public function deleteAction($id) {
        $EM = $this->getDoctrine()->getManager();
        $Cliente_repo = $EM->getRepository("AppBundle:Cliente");
        $Cliente = $Cliente_repo->find($id);

        $EM->remove($Cliente);
        $EM->flush();
        $status = "Cliente eliminado correctamente";
        $this->sesion->getFlashBag()->add("status", $status);

        return $this->redirectToRoute("queryCliente");
    }

}
