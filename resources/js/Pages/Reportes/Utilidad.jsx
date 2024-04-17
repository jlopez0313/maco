import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import InputLabel from "@/Components/Form/InputLabel";
import TextInput from "@/Components/Form/TextInput";
import Table from "@/Components/Table/Table";
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

    const onSetGastos = () => {

        const total = listaGastos.reduce(
            (sum, det) => sum + det.valor,
            0
        );

        const nacional = listaGastos.filter( detalle => detalle.origen == 'N' ) || []
        .reduce(
            (sum, det) => sum + det.valor,
            0
        )

        const importado = listaGastos.filter( detalle => detalle.origen == 'I' ) || []
        

        console.log(nacional, importado );

        return {
            total,
            nacional: nacional.reduce( (sum, det) => sum + det.valor, 0 ),
            importado: importado.reduce( (sum, det) => sum + det.valor, 0 ),
        }
    }
    
    const onSetCompraCredito = () => {
        const lista = listaFacturas.filter((item) => item.tipos_id == "1");
        const total = lista.map((item) => {
            return (
                item.detalles.reduce(
                    (sum, det) => sum + det.precio_venta * det.cantidad,
                    0
                ) || 0
            );
        });

        const nacional = []
        lista.forEach( item => { 
            const nacionales = item.detalles?.filter( detalle => detalle.producto?.inventario?.origen == 'N' ) || []
            nacional.push(...nacionales);
        })

        const importado = []
        lista.forEach( item => { 
            const importados = item.detalles?.filter( detalle => detalle.producto?.inventario?.origen == 'I' ) || []
            importado.push(...importados);

        })

        return {
            total,
            nacional: nacional.reduce( (sum, item) => { return sum += (item.cantidad * item.precio_venta) }, 0 ),
            importado: importado.reduce( (sum, item) => { return sum += (item.cantidad * item.precio_venta) }, 0 ),
        }
    }

    const onSetCompraContado = () => {
        const lista = listaFacturas.filter((item) => item.tipos_id == "2");
        const total = lista.map((item) => {
            return (
                item.detalles.reduce(
                    (sum, det) => sum + det.precio_venta * det.cantidad,
                    0
                ) || 0
            );
        });

        
        const nacional = lista.map( item => { return item.detalles?.filter( detalle => detalle.producto?.inventario?.origen == 'N' ) || [] })
        const importado = lista.map( item => { return item.detalles?.filter( detalle => detalle.producto?.inventario?.origen == 'I' ) || []})

        return {
            total,
            nacional: nacional.reduce( (item, sum) => { return sum += (item.cantidad * item.precio_venta) }, 0 ),
            importado: importado.reduce( (item, sum) => { return sum += (item.cantidad * item.precio_venta) }, 0 ),
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
            ['Inventario', toCurrency(inventario || 0), ''],
            ['Orden de Compra Contado', '', toCurrency(compraContado.total || 0)],
            ['', 'Nacional', toCurrency(compraContado.nacional || 0)],
            ['', 'Importado', toCurrency(compraContado.importado || 0)],
            [' ', ' ', ' '],
            ['Orden de Compra Crédito', '', toCurrency(compraCredito.total || 0)],
            ['', 'Nacional', toCurrency(compraCredito.nacional || 0)],
            ['', 'Importado', toCurrency(compraCredito.importado || 0)],
            [' ', ' ', ' '],
            ['Recaudos Crédito', '', toCurrency(recaudos || 0)],
            [' ', ' ', ' '],
            ['Gastos', '', toCurrency(gastos.total || 0)],
            ['', 'Nacional', toCurrency(gastos.nacional || 0)],
            ['', 'Importado', toCurrency(gastos.importado || 0)],
            [' ', ' ', ' '],
            ['Total', toCurrency(totalInventario || 0), ''],
            [' ', ' ', ' '],
            ['Caja Nacional', '', toCurrency(totalNacional || 0)],
            [' ', ' ', ' '],
            ['Caja Importado', '', toCurrency(totalImportado || 0)],

        )

        setList(_list);

    };

    const onBack = () => {
        history.back();
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
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                            <thead>
                                <tr className="font-bold text-left">
                                    <th className="px-6 pt-5 pb-4"> Concepto </th>
                                    <th className="px-6 pt-5 pb-4"> Inventario </th>
                                    <th className="px-6 pt-5 pb-4"> Orden de Compra </th>
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
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
