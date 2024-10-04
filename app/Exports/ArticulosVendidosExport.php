<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Facturas;
use App\Models\Gastos;

class ArticulosVendidosExport implements FromView
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $query = Facturas::with('detalles.producto.inventario', 'detalles.producto.impuestos.impuesto')
            ->whereBetween('created_at', [ $this->data['fecha_inicial'] . ' 00:00:00', $this->data['fecha_final'] . ' 23:59:59' ])
            ->get()
        ;

        return view('exports.articulos_vendidos', [
            'invoices' => $query
        ]);
    }
}
