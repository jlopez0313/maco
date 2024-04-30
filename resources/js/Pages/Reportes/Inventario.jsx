import PrimaryButton from '@/Components/Buttons/PrimaryButton';
import SecondaryButton from '@/Components/Buttons/SecondaryButton';
import InputLabel from '@/Components/Form/InputLabel';
import TextInput from '@/Components/Form/TextInput';
import Table from '@/Components/Table/Table';
import { goToQR } from '@/Helpers/Modals';
import { toCurrency } from '@/Helpers/Numbers';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';
import { useForm } from "@inertiajs/react";
import { useEffect, useState } from 'react';

export default function Inventario({ auth, facturas }) {

    const [ currentDate, setCurrentDate ] = useState( new Date() );

    const onBack = () => {
        history.back();
    }

    const onPrint = () => {
        window.print();
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Reporte de Inventario
                </h2>
            }
        >
            <Head title="Reporte de Inventario" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 text-xs">
                    Fecha: { currentDate.toLocaleString() }
                </div>

                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 no-print">
                    <div className="flex items-center justify-end mt-4 mb-4">
                        <SecondaryButton
                            className="ms-4"
                            onClick={() => onBack()}
                        >
                            Atras
                        </SecondaryButton>
                    </div>
                </div>
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    
                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                       
                        <table className="w-full whitespace-nowrap">
                            <tbody>
                                {
                                    facturas.map( (item, key) => {
                                        return  <>
                                            <tr className="font-bold text-left">
                                                <th colSpan={2} className="px-6 pt-5 pb-4 border-t"> Artículo </th>
                                                <th colSpan={2} className="px-6 pt-5 pb-4 border-t"> Orígen </th>
                                                <th colSpan={2} className="px-6 pt-5 pb-4 border-t"> Cantidad </th>
                                            </tr>
                                            <tr
                                                key={key}
                                                className="hover:bg-gray-100 focus-within:bg-gray-100"
                                            >
                                                <td colSpan={2} className="px-6 py-2 border-t"> { item.articulo } </td>
                                                <td colSpan={2} className="px-6 py-2 border-t"> { item.origenLabel } </td>
                                                <td colSpan={2} className="px-6 py-2 border-t"> { item.productos.reduce( (sum, item) => sum += item.cantidad, 0) } </td>
                                            </tr>
                                            <tr className="font-bold text-left">
                                                <th className="px-6 pt-5 pb-4"> Artículo </th>
                                                <th className="px-6 pt-5 pb-4"> Referencia </th>
                                                <th className="px-6 pt-5 pb-4"> Color </th>
                                                <th className="px-6 pt-5 pb-4"> Medida </th>
                                                <th className="px-6 pt-5 pb-4"> Cantidad </th>
                                                <th className="px-6 pt-5 pb-4"> Precio Costo </th>
                                            </tr>
                                            {
                                                item.productos.map( (prod, idx) => {
                                                    return <tr 
                                                        key={idx}
                                                        className="hover:bg-gray-100 focus-within:bg-gray-100"
                                                    >
                                                        <td className="px-6 py-2 border-t"> { item.articulo } </td>
                                                        <td className="px-6 py-2 border-t"> { prod.referencia } </td>
                                                        <td className="px-6 py-2 border-t"> { prod.color?.color } </td>
                                                        <td className="px-6 py-2 border-t"> { prod.medida?.medida } </td>
                                                        <td className="px-6 py-2 border-t"> { prod.cantidad } </td>
                                                        <td className="px-6 py-2 border-t"> { toCurrency(prod.precio) } </td>
                                                    </tr>
                                                })
                                            }
                                        </>
                                    })
                                }
                            </tbody>
                        </table>
                       
                    </div>

                    {
                        facturas.length ? 
                            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 no-print">
                                <div className="flex items-center justify-end mt-4 mb-4">
                                    <a
                                        className="border border-gray-300 rounded-md bg-white hover:bg-white-700 text-gray py-2 px-4 rounded text-xs uppercase shadow-sm font-semibold text-gray-700"
                                        href={`/reportes/inventario/excel`}
                                    >
                                        Excel
                                    </a>

                                    <SecondaryButton
                                        className="ms-4"
                                        onClick={onPrint}
                                    >
                                        Imprimir
                                    </SecondaryButton>

{/*                 
                                    <a
                                        className="border border-gray-300 ms-3 rounded-md bg-white hover:bg-white-700 text-gray py-2 px-4 rounded text-xs uppercase shadow-sm font-semibold text-gray-700"
                                        href={`/reportes/inventario/pdf`}
                                    >
                                        Imprimir
                                    </a>
*/}
                                    <SecondaryButton
                                        className="ms-4"
                                        onClick={() => goToQR(`/reportes/compras/qr?fecha_inicial=${data.fecha_inicial}&fecha_final=${data.fecha_final}`) }
                                    >
                                        QR
                                    </SecondaryButton>

                                </div>
                            </div> : null
                    }
                </div>
            </div>

        </AuthenticatedLayout>
    );
}
