<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Ejercicio;
use AppBundle\Form\EjercicioType;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Response;

class EjercicioController extends Controller {

    private $sesion;

    public function __construct() {
        $this->sesion = new Session();
    }

    public function queryAction(Request $request) {
        $isAjax = $request->isXmlHttpRequest();

        $datatable = $this->get('sg_datatables.factory')->create(\AppBundle\Datatables\EjercicioDatatable::class);
        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService = $this->get('sg_datatables.response');
            $responseService->setDatatable($datatable);
            $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
            $datatableQueryBuilder->buildQuery();

            return $responseService->getResponse();
        }

        return $this->render('cliente/query.html.twig', array(
                    'datatable' => $datatable,
        ));
    }

    public function addAction(Request $request) {
        $EM = $this->getDoctrine()->getManager();
        $Ejercicio = new Ejercicio();
        $form = $this->createForm(EjercicioType::class, $Ejercicio);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($this->esDniValido($form->get('nif')->getData())) {
                try {
                    $EM->persist($Ejercicio);
                    $EM->flush();
                    $status = "Ejercicio creado correctamente";
                    $this->sesion->getFlashBag()->add("status", $status);
                } catch (\Doctrine\DBAL\DBALException $ex) {
                    $status = $ex->getMessage();
                    $this->sesion->getFlashBag()->add("status", $status);
                }
                return $this->redirectToRoute("queryEjercicio");
            }
        }

        $params = array("accion" => "NUEVO",
            "cliente" => $Ejercicio,
            "form" => $form->createView());
        return $this->render("cliente/edit.html.twig", $params);
    }

    public function editAction(Request $request, $id) {
        $EM = $this->getDoctrine()->getManager();
        $Ejercicio_repo = $EM->getRepository("AppBundle:Ejercicio");
        $Ejercicio = $Ejercicio_repo->find($id);

        $form = $this->createForm(EjercicioType::class, $Ejercicio);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($this->esDniValido($form->get('nif')->getData())) {
                $EM->persist($Ejercicio);
                $EM->flush();
                $status = "Ejercicio modificado correctamente";
                $this->sesion->getFlashBag()->add("status", $status);
                return $this->redirectToRoute("queryEjercicio");
            }
        }

        $params = array("accion" => "MODIFICACIÓN",
            "cliente" => $Ejercicio,
            "form" => $form->createView());
        return $this->render("cliente/edit.html.twig", $params);
    }

    public function deleteAction($id) {
        $EM = $this->getDoctrine()->getManager();
        $Ejercicio_repo = $EM->getRepository("AppBundle:Ejercicio");
        $Ejercicio = $Ejercicio_repo->find($id);

        $EM->remove($Ejercicio);
        $EM->flush();
        $status = "Ejercicio eliminado correctamente";
        $this->sesion->getFlashBag()->add("status", $status);

        return $this->redirectToRoute("queryEjercicio");
    }

    public function queryAjaxAction(Request $request, $id) {
        $EM = $this->getDoctrine()->getManager();
        $Ejercicio_repo = $EM->getRepository("AppBundle:Ejercicio");
        $EjercicioObj = $Ejercicio_repo->createQueryBuilder('u')
                        ->where('u.id = :id')
                        ->setParameter('id', $id)
                        ->getQuery()->getResult()
        ;
        $Ejercicio["id"] = $EjercicioObj[0]->getId();
        $Ejercicio["anyo"] = $EjercicioObj[0]->getAnyo();
        $Ejercicio["descripcion"] = $EjercicioObj[0]->getDescripcion();
        $Ejercicio["fcInicio"] = $EjercicioObj[0]->getFcInicio()->format('Y-m-d');
        $Ejercicio["fcFin"] = $EjercicioObj[0]->getFcFin()->format('Y-m-d');
        $response = new Response();
        $response->setContent(json_encode($Ejercicio));
        $response->headers->set("Content-type", "application/json");
        return $response;
    }

    
}
