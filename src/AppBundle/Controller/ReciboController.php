<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Recibo;
use AppBundle\Reports\ImpresoRecibo;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use ZipArchive;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;

class ReciboController extends Controller {

    private $sesion;

    public function __construct() {
        $this->sesion = new Session();
    }

    public function queryAction(Request $request) {
        $isAjax = $request->isXmlHttpRequest();

        $datatable = $this->get('sg_datatables.factory')->create(\AppBundle\Datatables\ReciboDatatable::class);
        $datatable->buildDatatable();

        if ($isAjax) {
            $responseService = $this->get('sg_datatables.response');
            $responseService->setDatatable($datatable);
            $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
            $datatableQueryBuilder->buildQuery();

            return $responseService->getResponse();
        }

        return $this->render('recibo/query.html.twig', array(
                    'datatable' => $datatable,
        ));
    }


    public function generarAction($pedido_id) {
        $EM = $this->getDoctrine()->getManager();
        $Pedido_repo = $EM->getRepository("AppBundle:Pedido");
        $Pedido = $Pedido_repo->find($pedido_id);
        if ($Pedido->getRecibo() != null) {
            $params = array("id" => $Pedido->getRecibo()->getId());
        } else {
            $Recibo = new Recibo();
            $sigNumero = $this->siguienteNumero(2018);
            $Recibo->setFecha($Pedido->getFecha());
            $Recibo->setPedido($Pedido);
            $Recibo->setEjercicio($Pedido->getFecha()->format('Y'));
            $Recibo->setNumero($sigNumero);
            $EM->persist($Recibo);
            $EM->flush();
            $params = array("id" => $Recibo->getId());
        }
        return $this->redirectToRoute("imprimirRecibo", $params);
    }

    public function imprimirAction($id) {
        $EM = $this->getDoctrine()->getManager();
        $Recibo_repo = $EM->getRepository("AppBundle:Recibo");
        $Recibo = $Recibo_repo->find($id);

        $pdf = new ImpresoRecibo('P', 'mm', 'A4', $Recibo);

        return new Response($pdf->Output(), 200, array(
            'Content-Type' => 'application/pdf'));
    }

    public function siguienteNumero($ejercicio) {
        $EM = $this->getDoctrine()->getManager();
        $Recibo_repo = $EM->getRepository("AppBundle:Recibo");
        $UltimaRecibo = $Recibo_repo->createQueryBuilder('u')
                        ->select('max(u.numero) as ultimo')
                        ->where('u.ejercicio = :ejercicio')
                        ->setParameter('ejercicio', $ejercicio)
                        ->getQuery()->getResult();

        $numero = $UltimaRecibo[0]['ultimo'];
        if ($numero == null) {
            return 100;
        } else {
            return $numero + 1;
        }
    }

    public function deleteAction($id) {
        $EM = $this->getDoctrine()->getManager();
        $Recibo_repo = $EM->getRepository("AppBundle:Recibo");
        $Recibo = $Recibo_repo->find($id);
        $status = " Recibo " . $Recibo->getNumero() . '/' . $Recibo->getEjercicio() . " Eliminado Correctamente";
        $EM->remove($Recibo);
        $EM->flush();
        $this->sesion->getFlashBag()->add("status", $status);
        return $this->redirectToRoute("queryPedido");
    }

    public function exportarAction() {
        $EntityManager = $this->getDoctrine()->getManager();
        $Recibo_repo = $EntityManager->getRepository("AppBundle:Recibo");
        $ReciboAll = $Recibo_repo->findAll();

        $PHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $PHPExcel->setActiveSheetIndex(0);
        
        $this->insertarImagen('img/mamiya.jpg', $sheet);
        $antclase = "";
        $estilo = ['font' => ['bold' => true,
                'size' => 30,
                'name' => 'Verdana',
                'bold' => TRUE,
                'color' => ['rgb' => '190707']]];

        $estiloCentrado = ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]
        ];
 

        $sheet->setCellValue("B5", 'RELACIÓN DE RECIBOS');
        $sheet->mergeCells('B5:H5');
        $sheet->getStyle('B5:H5')->applyFromArray($estilo);
        $sheet->getStyle('B5:H5')->applyFromArray($estiloCentrado);
        $fila = 8;
        foreach ($ReciboAll as $row) {
          
        } 
		
        //$this->Ajustar($sheet);        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($PHPExcel);
        $filename = 'fichero.xlsx';
		$writer->save($filename);
        
        $response = new Response();

        $dispositionHeader = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename
        );
		
		$response->headers->set('Content-Disposition', 'attachment;filename='.$filename);
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'max-age=1');

        return $response;
    }

    public function insertarImagen($imagen, $sheet) {
        $gdImage = imagecreatefromjpeg($imagen);

        $objDrawing = new MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(155);
        $objDrawing->setWidth(140);

        $objDrawing->setWorksheet($sheet);

        return true;
    }

}
