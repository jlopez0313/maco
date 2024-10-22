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
import { useEffect, useState } from "react";

export default function Reportes({ auth, facturas, recaudos, gastos, productos }) {

    const { data: listaFacturas } = facturas;

    const { data: listaRecaudos } = recaudos;

    const { data: listaGastos } = gastos;

    const { data: listaProductos } = productos;

    const [list, setList] = useState([]);
    const [ currentDate, setCurrentDate ] = useState( new Date() );

    const onSetGastos = () => {

        const total = listaGastos.reduce(
            (sum, det) => sum + det.valor,
            0
        );

        const nacional = listaGastos.filter( detalle => detalle.origen == 'N' ) || []

        const importado = listaGastos.filter( detalle => detalle.origen == 'I' ) || []
        

        return {
            total,
            nacional: nacional.reduce( (sum, det) => sum + det.valor, 0 ),
            importado: importado.reduce( (sum, det) => sum + det.valor, 0 ),
        }
    }
    
    const onSetCompraCredito = () => {
        const lista = listaFacturas.filter((item) => item.forma_pago?.id == "2");
        const total = lista.map((item) => {
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

        const nacional = lista.map( item => { return item.detalles?.filter( detalle => detalle.producto?.inventario?.origen == 'N' ) || [] })
        const importado = lista.map( item => { return item.detalles?.filter( detalle => detalle.producto?.inventario?.origen == 'I' ) || []})

        return {
            total: total.reduce( (sum, item) => { return sum += item }, 0),
            nacional: nacional.flat(1).reduce( (sum, item) => { return sum += (item.cantidad * item.total_impuestos) + (item.cantidad * item.precio_venta) }, 0 ),
            importado: importado.flat(1).reduce( (sum, item) => { return sum += (item.cantidad * item.total_impuestos) + (item.cantidad * item.precio_venta) }, 0 ),
        }
    }

    const onSetCompraContado = () => {
        const lista = listaFacturas.filter((item) => item.forma_pago?.id == "1");

        const total = lista.map((item) => {
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

        
        const nacional = lista.map( item => { return item.detalles?.filter( detalle => detalle.producto?.inventario?.origen == 'N' ) || [] })
        const importado = lista.map( item => { return item.detalles?.filter( detalle => detalle.producto?.inventario?.origen == 'I' ) || []})

        return {
            total: total.reduce( (sum, item) => { return sum += item }, 0),
            nacional: nacional.flat(1).reduce( (sum, item) => { return sum += (item.cantidad * item.total_impuestos) + (item.cantidad * item.precio_venta) }, 0 ),
            importado: importado.flat(1).reduce( (sum, item) => { return sum += (item.cantidad * item.total_impuestos) +  (item.cantidad * item.precio_venta) }, 0 ),
        }
    }

    const onSetProductos = () => {
        
        return listaProductos.reduce( (sum, prod ) => {
            return sum += (prod.cantidad * prod.precio)
        }, 0)
    }
    
    const onSetRecaudos = () => {
        return listaRecaudos.reduce( (sum, prod ) => {
            return sum += prod.valor
        }, 0)
    }

    const onSearch = async () => {
        const _list = [];

        const inventario = onSetProductos()
        const compraCredito = onSetCompraCredito()
        const compraContado = onSetCompraContado()
        const recaudos = onSetRecaudos()
        const gastos = onSetGastos()

        const totalInventario = inventario;
        const totalNacional = compraContado.nacional + compraCredito.nacional - gastos.nacional;
        const totalImportado = compraContado.importado + compraCredito.importado - gastos.importado;


        _list.push(
            ['Inventario', toCurrency(inventario || 0), '', 'Todo el valor que se registró de todos los articulo'],
            ['Facturas de Contado', '', toCurrency(compraContado.total || 0), 'Valor Total de las ventas realizada'],
            ['', 'Nacional', toCurrency(compraContado.nacional || 0), 'Total Ventas de artículos Nacionales'],
            ['', 'Importado', toCurrency(compraContado.importado || 0), 'Total ventas de artículos Importados'],
            [' ', ' ', ' ', ' '],
            ['Facturas a Crédito', '', toCurrency(compraCredito.total || 0), 'Valor Total de las ventas a crédito'],
            ['', 'Nacional', toCurrency(compraCredito.nacional || 0), 'Total Ventas Crédito de artículos Nacionales'],
            ['', 'Importado', toCurrency(compraCredito.importado || 0), 'Total ventas Crédito de artículos Importados'],
            [' ', ' ', ' ', ' '],
            ['Recaudos Crédito', '', toCurrency(recaudos || 0), 'Valor Total de los Abonos realizados'],
            [' ', ' ', ' ', ' '],
            ['Gastos', '', toCurrency(gastos.total || 0), 'Valor total de todos los gastos registrados'],
            ['', 'Nacional', toCurrency(gastos.nacional || 0), 'Gasto que salio de la mercancía Nacional'],
            ['', 'Importado', toCurrency(gastos.importado || 0), 'Gasto que salio de la mercancía Importada'],
            [' ', ' ', ' ', ' '],
            ['Total', toCurrency(totalInventario || 0), '', 'Inventario + Ventas Contado + Ventas Crédito - Gastos'],
            [' ', ' ', ' ', ' '],
            ['Caja Nacional', '', toCurrency(totalNacional || 0), 'Valor de venta de contado - Gastos Contado'],
            [' ', ' ', ' ', ' '],
            ['Caja Importado', '', toCurrency(totalImportado || 0), 'Valor de Venta de importado - Gastos Importado'],

        )

        setList(_list);

    };

    const onBack = () => {
        history.back();
    }

    const onPrint = () => {
        window.print();
    }

    useEffect(() => {
        onSearch();
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Reporte de Utilidad
                </h2>
            }
        >
            <Head title="Reporte de Utilidad" />

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
                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <table className="w-full whitespace-nowrap">
                            <thead>
                                <tr className="font-bold text-left">
                                    <th className="px-6 pt-5 pb-4"> Concepto </th>
                                    <th className="px-6 pt-5 pb-4"> Inventario </th>
                                    <th className="px-6 pt-5 pb-4"> Orden de Compra </th>
                                    <th className="px-6 pt-5 pb-4"> Descripción </th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    list.map( (item, key) => {
                                        return <tr
                                          key={key}
                                          className="hover:bg-gray-100 focus-within:bg-gray-100"
                                        >
                                            {
                                                item.map( (dato, key2) =>{
                                                    return <td className="px-6 py-2 border-t" key={key2}> { dato } </td>
                                                })
                                            }
                                        </tr>
                                    })
                                }
                            </tbody>
                        </table>
                    </div>

                    {
                        list.length ? 
                            <div className="max-w-6xl mx-auto sm:px-6 lg:px-8 no-print">
                                <div className="flex items-center justify-end mt-4 mb-4">
                                    <a
                                        className="border border-gray-300 rounded-md bg-white hover:bg-white-700 text-gray py-2 px-4 rounded text-xs uppercase shadow-sm font-semibold text-gray-700"
                                        href={`/reportes/utilidad/excel`}
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
                                        href={`/reportes/utilidad/pdf`}
                                    >
                                        Imprimir
                                    </a>
                    */}
                                    <SecondaryButton
                                        className="ms-4"
                                        onClick={() => goToQR('/reportes/utilidad/qr') }
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
