import React, { useEffect, useState } from "react";
// import Layout from '@/Components/Layout';
import Icon from "@/Components/Icon";
// import SearchFilter from '@/Shared/SearchFilter';

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router, usePage } from "@inertiajs/react";
import Pagination from "@/Components/Table/Pagination";
import Table from "@/Components/Table/Table";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import Modal from "@/Components/Modal";
import { Form } from "./Detalle/Form";
import InputLabel from "@/Components/Form/InputLabel";
import TextInput from "@/Components/Form/TextInput";
import { AdminModal } from "@/Components/AdminModal";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import { toCurrency } from "@/Helpers/Numbers";
import { goToQR } from "@/Helpers/Modals";

export default ({ auth, factura }) => {
    const data = factura.detalles;

    const titles = [
        "Artículo",
        "Referencia",
        "Color",
        "Medida",
        "Cantidad",
        "Precio Venta Unit.",
        "Impuestos Unit.",
        "Total Impuestos",
        "Total",
    ];

    const [action, setAction] = useState("");
    const [adminModal, setAdminModal] = useState(false);
    const [id, setId] = useState(null);
    const [show, setShow] = useState(false);
    const [list, setList] = useState([]);
    const [sum, setSum] = useState(0);
    const [imptos, setImptos] = useState(0);

    const onSetAdminModal = (_id, action) => {
        setId(_id);
        setAdminModal(true);
        setAction(action);
    };

    const onConfirm = async ({ data }) => {
        if (action == "edit") {
            setAdminModal(false);
            onToggleModal(true);
        } else {
            onTrash(data);
        }
    };

    const onTrash = async (data) => {
        if (data) {
            await axios.delete(`/api/v1/detalles/${id}`);
            onReload();
        }
    };

    const onToggleModal = (isShown) => {
        if (!isShown) {
            setId(null);
        }
        setShow(isShown);
    };

    const onReload = () => {
        onToggleModal(false);

        router.visit(window.location.pathname);
    };

    const onSetList = () => {
        const _list = data.map((item) => {
            let impuestos = 0;

            item.producto?.impuestos.forEach((impto) => {
                if (impto.impuesto.tipo_impuesto == 'I') {
                    if (impto.impuesto.tipo_tarifa == "P") {
                        impuestos +=
                            ((item.precio_venta || 0) *
                                Number(impto.impuesto.tarifa)) /
                            100;
                    } else if (impto.impuesto.tipo_tarifa == "V") {
                        impuestos += Number(impto.impuesto.tarifa);
                    }
                }
            });

            return {
                id: item.id,
                articulo: item.producto?.inventario?.articulo || "",
                referenia: item.producto?.referencia || "",
                color: item.producto?.color?.color || "",
                medida: item.producto?.medida?.medida || "",
                cantidad: item.cantidad,
                precio: toCurrency(item.precio_venta || 0),
                impuestos: toCurrency(impuestos),
                total_impuestos: toCurrency(impuestos * item.cantidad),
                total: toCurrency( (impuestos * item.cantidad) + ((item.precio_venta || 0) * item.cantidad)),
            };
        });

        setList(_list);
        setShow(_list.length == 0);
    };

    const onSetSum = () => {
        const sum = data.reduce((sum, item) => {
            return sum + item.precio_venta * item.cantidad;
        }, 0);

        setSum(sum);

        let impuestos = 0;

        data.forEach((item) => {
            item.producto?.impuestos.forEach((impto) => {
                if (impto.impuesto.tipo_impuesto == 'I') {
                    if (impto.impuesto.tipo_tarifa == "P") {
                        impuestos +=
                            (((item.precio_venta || 0) *
                                Number(impto.impuesto.tarifa)) /
                                100) *
                            item.cantidad;
                    } else if (impto.impuesto.tipo_tarifa == "V") {
                        impuestos += Number(impto.impuesto.tarifa) * item.cantidad;
                    }
                }
            });
        });

        setImptos(impuestos);
    };

    const onBack = () => {
        router.visit("/remisiones");
    };

    const onSOAP = async () => {
        await axios.get(`/api/v1/soap/upload/${factura.id}`);
    };
    
    const onPrint = async () => {
        // window.print();
        await axios.get(`/api/v1/soap/status/${factura.id}`);
    };

    const goToPDF = async () => {
        // window.location.href = "/remisiones/pdf/" + factura.id;
        await axios.get(`/api/v1/soap/download/${factura.id}`);
    };

    useEffect(() => {
        onSetList();
        onSetSum();
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Detalle Órden de Compra
                </h2>
            }
        >
            <Head title="Detalle Órden de Compra" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="flex items-center justify-end mt-4 mb-4 no-print">
                        <SecondaryButton
                            className="ms-4"
                            onClick={() => onBack()}
                        >
                            Atras
                        </SecondaryButton>
                    </div>

                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg p-6">
                        <form>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel value="Documento" />

                                    <TextInput
                                        type="text"
                                        value={factura.id}
                                        className="mt-1 block w-full"
                                        readOnly={true}
                                    />
                                </div>

                                <div>
                                    <InputLabel value="Cliente" />

                                    <TextInput
                                        type="text"
                                        value={factura.cliente.nombre}
                                        className="mt-1 block w-full"
                                        readOnly={true}
                                    />
                                </div>

                                <div>
                                    <InputLabel htmlFor="fecha" value="Fecha" />

                                    <TextInput
                                        type="text"
                                        value={factura.created_at}
                                        className="mt-1 block w-full"
                                        readOnly={true}
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        htmlFor="ciudad"
                                        value="SubTotal"
                                    />

                                    <TextInput
                                        type="text"
                                        value={toCurrency(sum)}
                                        className="mt-1 block w-full"
                                        readOnly={true}
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        htmlFor="ciudad"
                                        value="Impuestos"
                                    />

                                    <TextInput
                                        type="text"
                                        value={toCurrency(imptos)}
                                        className="mt-1 block w-full"
                                        readOnly={true}
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        htmlFor="ciudad"
                                        value="Valor Total"
                                    />

                                    <TextInput
                                        type="text"
                                        value={toCurrency(sum + imptos)}
                                        className="mt-1 block w-full"
                                        readOnly={true}
                                    />
                                </div>
                            </div>
                        </form>
                    </div>

                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table
                            data={list}
                            links={[]}
                            titles={titles}
                            actions={[]}
                        />
                    </div>

                    <div className="flex items-center justify-end mt-4 mb-4 no-print">
                        {
                            factura.transaccionID && 
                                <SecondaryButton className="ms-4" onClick={onSOAP}>
                                    SOAP
                                </SecondaryButton>
                        }

                        <SecondaryButton className="ms-4" onClick={onPrint}>
                            Estado
                        </SecondaryButton>

                        <PrimaryButton className="ms-4 me-3" onClick={goToPDF}>
                            PDF
                        </PrimaryButton>

                        <SecondaryButton
                            className="ms-4"
                            onClick={() =>
                                goToQR("/remisiones/qr/" + factura.id)
                            }
                        >
                            QR
                        </SecondaryButton>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};
