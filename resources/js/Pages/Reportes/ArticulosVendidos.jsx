import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import InputLabel from "@/Components/Form/InputLabel";
import TextInput from "@/Components/Form/TextInput";
import Table from "@/Components/Table/Table";
import { goToQR } from "@/Helpers/Modals";
import { toCurrency } from "@/Helpers/Numbers";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router } from "@inertiajs/react";
import { useForm } from "@inertiajs/react";
import { useState } from "react";

export default function Reportes({ auth }) {
    const { data, setData, processing, errors, reset } = useForm({
        fecha_inicial: "",
        fecha_final: "",
    });

    const titles = [
        "Fecha",
        "Referencia",
        "Origen",
        "Cantidad",
        "Valor Unitario",
        "Valor Total",
    ];

    const [list, setList] = useState([]);

    const onSearch = async () => {
        const {
            data: { data: lista },
        } = await axios.post(`/api/v1/reportes/articulos_vendidos/`, data);
        let _list = [];

        lista.forEach((item) => {
            item.detalles?.forEach((det) => {
                _list.push({
                    fecha: item.created_at,
                    referencia: det.producto?.referencia || "",
                    origen: det.producto?.inventario?.origenLabel || "",
                    cantidad: det.cantidad || 0,
                    valor: toCurrency(det.precio_venta) || 0,
                    total: toCurrency(det.precio_venta * det.cantidad) || 0,
                });
            });
        });

        setList(_list);
    };

    const onBack = () => {
        history.back();
    };

    const onPrint = () => {
        window.print();
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Reporte de Artículos Vendidos
                </h2>
            }
        >
            <Head title="Reporte de Artículos Vendidos" />

            <div className="py-12">
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
                    <div className="flex items-center justify-between mt-4 mb-6 no-print">
                        <div className="w-full m-2">
                            <InputLabel
                                htmlFor="nombre"
                                value="Fecha Inicial"
                            />
                            <TextInput
                                placeholder="Fecha Inicial..."
                                id="nombre"
                                type="date"
                                name="nombre"
                                className="mt-1 block w-full me-4"
                                autoComplete="nombre"
                                value={data.fecha_inicial}
                                onChange={(e) =>
                                    setData("fecha_inicial", e.target.value)
                                }
                            />
                        </div>

                        <div className="w-full m-2">
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
                                onChange={(e) =>
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
                            onTrash={() => {}}
                            titles={titles}
                            actions={[]}
                        />
                    </div>

                    {
                        list.length ?
                            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 no-print">
                                <div className="flex items-center justify-end mt-4 mb-4">
                                    <a
                                        className="border border-gray-300 rounded-md bg-white hover:bg-white-700 text-gray py-2 px-4 rounded text-xs uppercase shadow-sm font-semibold text-gray-700"
                                        href={`/reportes/articulos_vendidos/excel?fecha_inicial=${data.fecha_inicial}&fecha_final=${data.fecha_final}`}
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
                                        href={`/reportes/articulos_vendidos/pdf?fecha_inicial=${data.fecha_inicial}&fecha_final=${data.fecha_final}`}
                                    >
                                        Imprimir
                                    </a>
                    */}
                                    <SecondaryButton
                                        className="ms-4"
                                        onClick={() => goToQR(`/reportes/articulos_vendidos/qr?fecha_inicial=${data.fecha_inicial}&fecha_final=${data.fecha_final}`) }
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
