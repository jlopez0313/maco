import Table from '@/Components/Table/Table';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';

export default function Reportes({ auth }) {

    const titles = [
        'Reporte',
        'Descripción',
    ]
    
    const list = [
        {
            id: 1,
            parametro: 'Información de Inventario',
            descripcion: 'Reporte de inventario de artículos.',
            ruta: 'reportes/inventario'
        },
        {
            id: 2,
            parametro: 'Existencia por Articulo',
            descripcion: 'Reporte de inventario de un artículo específico',
            ruta: 'reportes/existencia_articulo'
        },
        {
            id: 3,
            parametro: 'Artículos Vendidos',   
            descripcion: 'Reporte Unitario de venta por artículo.',
            ruta: 'reportes/articulos_vendidos'
        },
        {
            id: 4,
            parametro: 'Información Ventas',   
            descripcion: 'Reporte indica el registro de las ventas realizadas hasta el momento.',
            ruta: 'reportes/ventas'
        },
        {
            id: 5,
            parametro: 'Gastos de la Compañía',   
            descripcion: 'Reporte indica el registro de los Gastos realizados hasta el momento.',
            ruta: 'reportes/gastos'
        },
        {
            id: 6,
            parametro: 'Estado de Cuenta General',   
            descripcion: 'Reporte Completo de los diferentes Clientes que tienen saldo por pagar hasta el momento.',
            ruta: 'reportes/estado_cuenta_general'
        },
        {
            id: 7,
            parametro: 'Estado de Cuenta por Cliente',   
            descripcion: 'Reporte unitario del saldo por pagar que tiene el cliente especifico consultado.',
            ruta: 'reportes/estado_cuenta_cliente'
        },
        {
            id: 8,
            parametro: 'Información Utilidad',   
            descripcion: 'Muestra las perdidas o ganancias que ha tenido la compañia.',
            ruta: 'reportes/utilidad'
        },
    ]

    const onNavigate = (id) => {
        const route = list.find( item => item.id === id )
        router.get( route.ruta )
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Reportes</h2>}
        >
            <Head title="Reportes" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table data={list} titles={titles} actions={['chevron-right']} onEdit={ onNavigate } />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
