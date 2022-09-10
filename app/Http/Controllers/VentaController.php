<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venta;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\DetalleVenta;
use DB;


class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        //Seccion del manejo de la venta
        //return $r;

        $venta = new Venta;

        $venta->folio=$r->get('folio');
        $venta->fecha_venta=$r->get('fecha_venta');
        $venta->num_articulos=$r->get('num_articulos');
        $venta->subtotal=$r->get('subtotal');
        $venta->iva=$r->get('iva');
        $venta->total=$r->get('total');

        $venta->save();

        //Fin de manejo de la ventas

        //Obtenemos del Request el json de los detalles
        $detalles = $r->get('detalles');

        //Insertamos los detalles a la tabla detalle_vemtas
        DetalleVenta::insert($detalles);

        //Actualizamos el estado de los inventarios
        for ($i=0; $i < count($detalles); $i++) { 

            $cantidadVendida=$detalles[$i]['cantidad'];
            $productoVendido=$detalles[$i]['sku'];

            DB::update("UPDATE productos
                SET cantidad=cantidad-$cantidadVendida
                WHERE sku=$productoVendido");

           
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return $venta=Venta::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ticket($folio){
        $venta= Venta::find($folio);
        $altura = 100;

       //Definimos el tamaño del ticket
       $pdf = new Fpdf('P', 'mm', array(78,$altura ));

       $pdf->AddPage();

      $pdf->SetMargins(3,2,3);
       $pdf->SetFont('Arial', 'B', 7);
       $pdf->Cell(60,3,'ABARROTES LA LUPITA',0,1,'C');
       $pdf->Cell(10,3, 'FOLIO:', 0,0,'L');
       $pdf->Cell(25,3, $venta->folio,0,0,'L');
       $pdf->Cell(15,3, 'FECHA:',0,0,'L');
       $pdf->Cell(15,3, $venta->fecha_venta, 0,1,'L');
       $pdf->Cell(65,1,'','B','C');
       $pdf->Ln(2);

       $pdf->SetFont('Arial', 'B', 6);
       $pdf->Cell(10,3, 'SKU',1,0,'C');
       $pdf->Cell(25,3, 'PRODUTO',1,0,'C');
       $pdf->Cell(8,3, 'CANT',1,0,'C');
       $pdf->Cell(10,3, 'P.U',1,0,'C');
       $pdf->Cell(15,3,'TOTAL',1,1,'C');

       $detalles=$venta->detalles;

       foreach ($detalles as $detalle) {
            $pdf->Cell(10,3,$detalle->sku,0,0,'C');
            $pdf->Cell(25,3,$detalle->productos->nombre,0,0,'C');
            $pdf->Cell(8,3,$detalle->cantidad,0,0,'C');
            $pdf->Cell(10,3,$detalle->precio,0,0,'C');
            $pdf->Cell(15,3,$detalle->total,0,1,'C');
       }

       $pdf->OutPut();
       exit;
    }
}
