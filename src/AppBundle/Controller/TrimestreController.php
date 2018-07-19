<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Trimestre;
use AppBundle\Form\TrimestreType;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Response;

class TrimestreController extends Controller {

    private $sesion;

    public function __construct() {
        $this->sesion = new Session();
    }

    public function queryAction(Request $request) {
        $isAjax = $request->isXmlHttpRequest();

        $datatable = $this->get('sg_datatables.factory')->create(\AppBundle\Datatables\TrimestreDatatable::class);
        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService = $this->get('sg_datatables.response');
            $responseService->setDatatable($datatable);
            $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
            $datatableQueryBuilder->buildQuery();

            return $responseService->getResponse();
        }

        return $this->render('trimestre/query.html.twig', array(
                    'datatable' => $datatable,
        ));
    }

    public function addAction(Request $request) {
        $EM = $this->getDoctrine()->getManager();
        $Trimestre = new Trimestre();
        $form = $this->createForm(TrimestreType::class, $Trimestre);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($this->esDniValido($form->get('nif')->getData())) {
                try {
                    $EM->persist($Trimestre);
                    $EM->flush();
                    $status = "Trimestre creado correctamente";
                    $this->sesion->getFlashBag()->add("status", $status);
                } catch (\Doctrine\DBAL\DBALException $ex) {
                    $status = $ex->getMessage();
                    $this->sesion->getFlashBag()->add("status", $status);
                }
                return $this->redirectToRoute("queryTrimestre");
            }
        }

        $params = array("accion" => "NUEVO",
            "Trimestre" => $Trimestre,
            "form" => $form->createView());
        return $this->render("trimestre/edit.html.twig", $params);
    }

    public function editAction(Request $request, $id) {
        $EM = $this->getDoctrine()->getManager();
        $Trimestre_repo = $EM->getRepository("AppBundle:Trimestre");
        $Trimestre = $Trimestre_repo->find($id);

        $form = $this->createForm(TrimestreType::class, $Trimestre);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($this->esDniValido($form->get('nif')->getData())) {
                $EM->persist($Trimestre);
                $EM->flush();
                $status = "Trimestre modificado correctamente";
                $this->sesion->getFlashBag()->add("status", $status);
                return $this->redirectToRoute("queryTrimestre");
            }
        }

        $params = array("accion" => "MODIFICACIÓN",
            "Trimestre" => $Trimestre,
            "form" => $form->createView());
        return $this->render("Trimestre/edit.html.twig", $params);
    }

    public function deleteAction($id) {
        $EM = $this->getDoctrine()->getManager();
        $Trimestre_repo = $EM->getRepository("AppBundle:Trimestre");
        $Trimestre = $Trimestre_repo->find($id);

        $EM->remove($Trimestre);
        $EM->flush();
        $status = "Trimestre eliminado correctamente";
        $this->sesion->getFlashBag()->add("status", $status);

        return $this->redirectToRoute("queryTrimestre");
    }

    public function queryAjaxAction($id) {
        $EM = $this->getDoctrine()->getManager();
        $Trimestre_repo = $EM->getRepository("AppBundle:Trimestre");
        $TrimestreObj = $Trimestre_repo->createQueryBuilder('u')
                        ->where('u.id = :id')
                        ->setParameter('id', $id)
                        ->getQuery()->getResult();

        $Trimestre['id'] = $TrimestreObj[0]->getId();
        $Trimestre['fcInicio'] = $TrimestreObj[0]->getFcInicio()->format('Y-m-d');
        $Trimestre['fcFin'] = $TrimestreObj[0]->getFcFin()->format('Y-m-d');
        $Trimestre['descripcion'] = $TrimestreObj[0]->getDescripcion();
        $Trimestre['ejercicio']["id"] = $TrimestreObj[0]->getEjercicio()->getId();
        $Trimestre['ejercicio']["anyo"] = $TrimestreObj[0]->getEjercicio()->getAnyo();
        $Trimestre['ejercicio']["descripcion"] = $TrimestreObj[0]->getEjercicio()->getDescripcion();
        $Trimestre['ejercicio']["fcInicio"] = $TrimestreObj[0]->getEjercicio()->getFcInicio()->format('Y-m-d');
        $Trimestre['ejercicio']["fcFin"] = $TrimestreObj[0]->getEjercicio()->getFcFin()->format('Y-m-d');

        $response = new Response();
        $response->setContent(json_encode($Trimestre));
        $response->headers->set("Content-type", "application/json");
        return $response;
    }

    public function selectAjaxAction($ejercicio_id) {
        $EM = $this->getDoctrine()->getManager();
        $Ejercicio_repo = $EM->getRepository("AppBundle:Ejercicio");
        $Ejercicio = $Ejercicio_repo->find($ejercicio_id);
        $Trimestre_repo = $EM->getRepository("AppBundle:Trimestre");

        $TrimestreObjAll = $Trimestre_repo->createQueryBuilder('u')
                        ->where('u.ejercicio = :ejercicio')
                        ->setParameter('ejercicio', $Ejercicio)
                        ->getQuery()->getResult();
        $i=0;
        foreach ($TrimestreObjAll as $TrimestreObj) {
            $Trimestre[$i]['id'] = $TrimestreObj->getId();
            $Trimestre[$i]['fcInicio'] = $TrimestreObj->getFcInicio()->format('Y-m-d');
            $Trimestre[$i]['fcFin'] = $TrimestreObj->getFcFin()->format('Y-m-d');
            $Trimestre[$i]['descripcion'] = $TrimestreObj->getDescripcion();
            $i++;
        }
        $response = new Response();
        $response->setContent(json_encode($Trimestre));
        $response->headers->set("Content-type", "application/json");
        return $response;
    }

}
