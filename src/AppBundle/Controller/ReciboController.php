<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Recibo;
use AppBundle\Reports\ImpresoRecibo;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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
        $EjercicioActual_repo = $EM->getRepository("AppBundle:EjercicioActual");
        $EjercicioActual = $EjercicioActual_repo->find(1);
        $Ejercicio = $EjercicioActual->getEjercicio();

        $Pedido = $Pedido_repo->find($pedido_id);
        if ($Pedido->getRecibo() != null) {
            $params = array("id" => $Pedido->getRecibo()->getId());
        } else {
            $Recibo = new Recibo();
            $sigNumero = $this->siguienteNumero($Ejercicio);
            $Recibo->setEjercicio($Ejercicio);
            $Recibo->setFecha($Pedido->getFecha());
            $Recibo->setPedido($Pedido);
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

    public function siguienteNumero($Ejercicio) {
        $EM = $this->getDoctrine()->getManager();
        $Recibo_repo = $EM->getRepository("AppBundle:Recibo");
        $UltimoRecibo = $Recibo_repo->createQueryBuilder('u')
                        ->select('max(u.numero) as ultimo')
                        ->where('u.ejercicio = :ejercicio')
                        ->setParameter('ejercicio', $Ejercicio)
                        ->getQuery()->getResult();

        $numero = $UltimoRecibo[0]['ultimo'];
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
        return $this->redirectToRoute("queryRecibo");
    }

    public function exportarAction(Request $request) {

        $form = $this->createForm(\AppBundle\Form\FiltroFechaType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->get('startDate')->getData() != '') {
                $filename = 'recibos.xlsx';
                $response = new Response();
                $dispositionHeader = $response->headers->makeDisposition(
                        ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename
                );

                $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename);
                $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                $response->headers->set('Pragma', 'public');
                $response->headers->set('Cache-Control', 'max-age=1');
                $response->setContent(file_get_contents($filename));

                return $response;
            } else {
                $this->sesion->getFlashBag()->add("status", "Error debe haber al menos una selección ");
                return $this->render('recibo/exportar.html.twig', array("form" => $form->createView()));
            }
        } else {
            return $this->render('recibo/exportar.html.twig', array("form" => $form->createView()));
        }
    }

    public function finExportarAction(Request $request) {


        return $this->render('recibo/fin.html.twig');
    }

    public function ajaxExportarAction($fcini, $fcfin) {

        $EntityManager = $this->getDoctrine()->getManager();
        $Recibo_repo = $EntityManager->getRepository("AppBundle:Recibo");
        $ReciboAll = $Recibo_repo->createQueryBuilder('u')
                        ->where('u.fecha between :fcini and :fcfin')
                        ->setParameter('fcini', $fcini)
                        ->setParameter('fcfin', $fcfin)
                        ->getQuery()->getResult();

        $PHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $PHPExcel->setActiveSheetIndex(0);

        $this->insertarImagen('img/mamiya.jpg', $sheet);
        $antclase = "";
        $estiloTitulo = ['font' => ['bold' => true,
                'size' => 20,
                'name' => 'Verdana',
                'color' => ['rgb' => '190707']]];

        $estiloCentrado = ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]];


        $estiloCabecera = ['font' => ['bold' => true,
                'size' => 10,
                'name' => 'Verdana',
                'color' => ['rgb' => '190707']],
            ''];

        $fuenteNormal = array('bold' => false,
            'size' => 10,
            'name' => 'Verdana',
            'color' => array('rgb' => '190707'));

        $fuenteBold = array('bold' => true,
            'size' => 10,
            'name' => 'Verdana',
            'color' => array('rgb' => '190707'));

        $estiloMoneda = array('font' => $fuenteNormal,
            'code' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR);
        $estiloFecha = array('font' => $fuenteNormal,
            'code' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);

        $sheet->setCellValue("D3", 'RELACIÓN DE RECIBOS');
        $sheet->mergeCells('D3:J3');
        $sheet->getStyle('D3:J3')->applyFromArray($estiloTitulo);

        $row = 8;
        $sheet->setCellValueByColumnAndRow(2, $row, 'Ejercicio');
        $sheet->setCellValueByColumnAndRow(3, $row, 'Nº Recibo');
        $sheet->setCellValueByColumnAndRow(4, $row, 'Fecha');
        $sheet->setCellValueByColumnAndRow(5, $row, 'Descripción');
        $sheet->setCellValueByColumnAndRow(6, $row, 'Total Pedido');
        $sheet->setCellValueByColumnAndRow(7, $row, 'Descuento');
        $sheet->setCellValueByColumnAndRow(8, $row, 'Base Imponible');
        $sheet->setCellValueByColumnAndRow(9, $row, 'Cuota IVA');
        $sheet->setCellValueByColumnAndRow(10, $row, 'Importe Total');
        $rango = 'B' . $row . ':J' . $row;
        $sheet->getStyle($rango)->applyFromArray($estiloCabecera);

        for ($col = 'B'; $col < 'L'; $col++) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $row++;
        foreach ($ReciboAll as $Recibo) {
            $sheet->setCellValueByColumnAndRow(2, $row, $Recibo->getEjercicio()->getAnyo());
            $sheet->setCellValueByColumnAndRow(3, $row, $Recibo->getNumero());
            $sheet->setCellValueByColumnAndRow(4, $row, $Recibo->getFecha()->format('d/m/Y'));
            $sheet->setCellValueByColumnAndRow(5, $row, $Recibo->getPedido()->getObservaciones());
            $sheet->setCellValueByColumnAndRow(6, $row, $Recibo->getPedido()->getTotalServicio());
            $sheet->setCellValueByColumnAndRow(7, $row, $Recibo->getPedido()->getTotalDescuento());
            $sheet->setCellValueByColumnAndRow(8, $row, $Recibo->getPedido()->getBaseImponible());
            $sheet->setCellValueByColumnAndRow(9, $row, $Recibo->getPedido()->getCuotaIVA());
            $sheet->setCellValueByColumnAndRow(10, $row, $Recibo->getPedido()->getTotalPedido());
            $row++;
        }

        $formatoCondicional = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
        $formatoCondicional->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CELLIS);
        $formatoCondicional->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_EQUAL);
        $formatoCondicional->addCondition('0');
        $formatoCondicional->getStyle()->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $row++;
        $rango = 'F9:J' . $row;
        $sheet->getStyle($rango)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
        $sheet->getStyle($rango)->setConditionalStyles(array($formatoCondicional));
        $rango = 'B9:D' . $row;
        $row--;
        $sheet->getStyle($rango)->applyFromArray($estiloCentrado);
        $sheet->setCellValueByColumnAndRow(6, $row+1, '=SUM(F9:F'.$row.')');
        $sheet->setCellValueByColumnAndRow(7, $row+1, '=SUM(G9:G'.$row.')');
        $sheet->setCellValueByColumnAndRow(8, $row+1, '=SUM(H9:H'.$row.')');
        $sheet->setCellValueByColumnAndRow(9, $row+1, '=SUM(I9:I'.$row.')');
        $sheet->setCellValueByColumnAndRow(10, $row+1, '=SUM(J9:J'.$row.')');
        
        
        //$this->Ajustar($sheet);        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($PHPExcel);
        $filename = 'recibos.xlsx';
        $writer->save($filename);

        $response = new Response();

        $response->setContent(json_encode($filename));
        $response->headers->set("Content-type", "application/json");

//        $dispositionHeader = $response->headers->makeDisposition(
//                ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename
//        );
//
//        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename);
//        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        $response->headers->set('Pragma', 'public');
//        $response->headers->set('Cache-Control', 'max-age=1');
//        $response->setContent(file_get_contents($filename));

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
        $objDrawing->setHeight(150);
        $objDrawing->setWidth(135);

        $objDrawing->setWorksheet($sheet);

        return true;
    }

}
