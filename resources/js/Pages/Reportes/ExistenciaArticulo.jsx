import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import InputLabel from "@/Components/Form/InputLabel";
import Select from "@/Components/Form/Select";
import TextInput from "@/Components/Form/TextInput";
import Table from "@/Components/Table/Table";
import { goToQR } from "@/Helpers/Modals";
import { toCurrency } from "@/Helpers/Numbers";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router } from "@inertiajs/react";
import { useForm } from "@inertiajs/react";
import { useState } from "react";

export default function Reportes({ auth, inventarios }) {
    
    const { data, setData, processing, errors, reset } = useForm({
        inventario: "",
    });

    const [list, setList] = useState({});
    const [ currentDate, setCurrentDate ] = useState( new Date() );

    const onSearch = async () => {
        const {
            data: { data: lista },
        } = await axios.post(`/api/v1/reportes/existencia_articulo/`, data);

        setList(lista);
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
                    Reporte de existencias por artículo
                </h2>
            }
        >
            <Head title="Reporte de existencias por artículo" />

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
                    <div className="flex items-center justify-between mt-4 mb-6 no-print">
                        <div className="w-full m-2">
                            <InputLabel
                                htmlFor="inventario"
                                value="Artículo"
                            />
                            <Select
                                id="inventario"
                                name="inventario"
                                className="mt-1 block w-full me-4"
                                autoComplete="inventario"
                                value={data.inventario}
                                onChange={(e) =>
                                    setData("inventario", e.target.value)
                                }
                            >
                                {
                                    inventarios.map( (item, key) => {
                                        return <option value={item.id} key={key}> {item.articulo} </option>
                                    })
                                }
                            </Select>
                        </div>

                        <PrimaryButton
                            className="ms-4"
                            onClick={() => onSearch()}
                        >
                            Buscar
                        </PrimaryButton>
                    </div>

                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <table className="w-full whitespace-nowrap">
                            <thead>
                                <tr className="font-bold text-left">
                                    <th colSpan={2} className="px-6 pt-5 pb-4"> Artículo </th>
                                    <th colSpan={2} className="px-6 pt-5 pb-4"> Orígen </th>
                                    <th colSpan={2} className="px-6 pt-5 pb-4"> Cantidad </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    className="hover:bg-gray-100 focus-within:bg-gray-100"
                                >
                                    <td colSpan={2} className="px-6 py-2 border-t"> { list.articulo } </td>
                                    <td colSpan={2} className="px-6 py-2 border-t"> { list.origen_label } </td>
                                    <td colSpan={2} className="px-6 py-2 border-t"> { list.productos?.reduce( (sum, item) => sum += item.cantidad, 0) } </td>
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
                                    list.productos?.map( (prod, idx) => {
                                        return <tr 
                                            key={idx}
                                            className="hover:bg-gray-100 focus-within:bg-gray-100"
                                        >
                                            <td className="px-6 py-2 border-t"> { list.articulo } </td>
                                            <td className="px-6 py-2 border-t"> { prod.referencia } </td>
                                            <td className="px-6 py-2 border-t"> { prod.color?.color } </td>
                                            <td className="px-6 py-2 border-t"> { prod.medida?.medida } </td>
                                            <td className="px-6 py-2 border-t"> { prod.cantidad } </td>
                                            <td className="px-6 py-2 border-t"> { toCurrency(prod.precio) } </td>
                                        </tr>
                                    })
                                }
                            </tbody>
                        </table>
                    </div>

                    {
                        list.productos ?
                            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 no-print">
                                <div className="flex items-center justify-end mt-4 mb-4">
                                    <a
                                        className="border border-gray-300 rounded-md bg-white hover:bg-white-700 text-gray py-2 px-4 rounded text-xs uppercase shadow-sm font-semibold text-gray-700"
                                        href={`/reportes/existencia_articulo/excel?inventario=${data.inventario}`}
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
                                        href={`/reportes/existencia_articulo/pdf?inventario=${data.inventario}`}
                                    >
                                        Imprimir
                                    </a>
*/}
                                    <SecondaryButton
                                        className="ms-4"
                                        onClick={() => goToQR(`/reportes/existencia_articulo/qr?inventario=${data.inventario}`) }
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
