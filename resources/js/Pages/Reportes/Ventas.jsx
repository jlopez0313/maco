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
import { useState } from 'react';

export default function Reportes({ auth }) {

    const { data, setData, processing, errors, reset } = useForm({
        fecha_inicial: '',
        fecha_final: '',
    });

    const titles = [
        "Código",
        "Fecha",
        "Cliente",
        "Forma de Pago",
        "Valor Total"
    ];

    const [list, setList] = useState([]);
    const [ currentDate, setCurrentDate ] = useState( new Date() );
    const [total, setTotal] = useState(0);
    
    const onSearch = async() => {
        const {data: {data: lista}} = await axios.post(`/api/v1/reportes/ventas`, data);
        
        const sum = lista.map((item) => {
                        
            item.detalles.forEach((_item) => {
                let impuestos = 0;

                _item.producto?.impuestos.forEach((impto) => {
                    if (impto.impuesto?.tipo_impuesto == "I") {
                        if (impto.impuesto.tipo_tarifa == "P") {
                            impuestos +=
                                ((_item.precio_venta || 0) *
                                    Number(impto.impuesto.tarifa)) /
                                100;
                        } else if (impto.impuesto.tipo_tarifa == "V") {
                            impuestos += Number(impto.impuesto.tarifa);
                        }
                    }
                });

                _item.total_impuestos = impuestos;
            });
            
            return (
                item.detalles.reduce(
                    (sum, det) =>
                        sum +
                        det.precio_venta * det.cantidad +
                        det.total_impuestos * det.cantidad,
                    0
                ) || 0
            );
        });

        let _sum = 0;
        const _list = lista.map((item, idx) => {
            _sum += item.forma_pago?.id == 1 && item.estado == 'C' ? (sum[idx] || 0) : 0;

            return {
                codigo: item.id,
                fecha: item.created_at,
                cliente: item.cliente?.nombre || "",
                payment: item.forma_pago?.descripcion || "",
                valor_total: toCurrency(sum[idx] || 0),
            };
        });

        setTotal(_sum);
        setList(_list);
    };

    
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
                    Reporte de Ventas
                </h2>
            }
        >
            <Head title="Reporte de Ventas" />

            <div className="py-12">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8 text-xs">
                    Fecha: { currentDate.toLocaleString() }
                </div>

                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8 no-print">
                    <div className="flex items-center justify-end mt-4 mb-4">
                        <SecondaryButton
                            className="ms-4"
                            onClick={() => onBack()}
                        >
                            Atras
                        </SecondaryButton>
                    </div>
                </div>
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between mt-4 mb-6 no-print">
                        
                        <div className='w-full m-2'>
                            <InputLabel htmlFor="nombre" value="Fecha Inicial" />
                            <TextInput
                                placeholder="Fecha Inicial..."
                                id="nombre"
                                type="date"
                                name="nombre"
                                className="mt-1 block w-full me-4"
                                autoComplete="nombre"
                                value={data.fecha_inicial}
                                onChange={ (e) => 
                                    setData("fecha_inicial", e.target.value)
                                }
                            />
                        </div>

                        <div className='w-full m-2'>
                            <InputLabel htmlFor="nombre" value="Fecha Final" />
                            <TextInput
                                placeholder="Fecha Final..."
                                id="nombre"
                                type="date"
                                name="nombre"
                                min={data.fecha_inicial}
                                className="mt-1 block w-full me-4"
                                autoComplete="nombre"
                                value={data.fecha_final}
                                onChange={ (e) => 
                                    setData("fecha_final", e.target.value)
                                }
                            />
                        </div>

                            <PrimaryButton
                                className="ms-4"
                                onClick={() => onSearch()}
                            >
                                Buscar
                            </PrimaryButton>
                    </div>

                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table
                            data={list}
                            links={[]}
                            onEdit={() => {}}
                            onRow={() => {}}
                            onTrash={() => {}}
                            titles={titles}
                            actions={[]}
                        />
                        
                        <span className="font-bold mt-10 ms-5 mb-5 flex"> Total Ventas Contado: {toCurrency(total)}  </span>

                    </div>

                    {
                        list.length ? 
                            <div className="max-w-6xl mx-auto sm:px-6 lg:px-8 no-print">
                                <div className="flex items-center justify-end mt-4 mb-4">
                                    <a
                                        className="border border-gray-300 rounded-md bg-white hover:bg-white-700 text-gray py-2 px-4 rounded text-xs uppercase shadow-sm font-semibold text-gray-700"
                                        href={`/reportes/ventas/excel?fecha_inicial=${data.fecha_inicial}&fecha_final=${data.fecha_final}`}
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
                                        href={`/reportes/ventas/pdf?fecha_inicial=${data.fecha_inicial}&fecha_final=${data.fecha_final}`}
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