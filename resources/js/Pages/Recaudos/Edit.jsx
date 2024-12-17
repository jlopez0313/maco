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
import { Form } from "./Form";
import InputLabel from "@/Components/Form/InputLabel";
import TextInput from "@/Components/Form/TextInput";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import { toCurrency } from "@/Helpers/Numbers";
import { goToQR } from "@/Helpers/Modals";
import { forcePrint } from "@/Helpers/Print";

export default ({ auth, factura }) => {
    const [show, setShow] = useState(false);
    const [list, setList] = useState([]);
    const [sum, setSum] = useState(0);
    const [saldo, setSaldo] = useState(0);

    const data = factura.detalles;
    const recaudos = factura.recaudos;

    const titles = ["Código", "Valor", "Descripción", "Fecha"];

    const [id, setId] = useState(null);

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
        const _list = recaudos.map((item) => {
            return {
                id: item.id,
                codigo: item.id,
                valor: toCurrency(item.valor),
                descripcion: item.descripcion,
                fecha: item.created_at,
            };
        });

        setList(_list);
    };

    const onSetSum = () => {
        data.forEach((_item) => {
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

        const sum = data.reduce((sum, item) => {
            return (
                sum +
                item.precio_venta * item.cantidad +
                item.total_impuestos * item.cantidad
            );
        }, 0);

        const saldo = recaudos.reduce((sum, item) => {
            return sum + item.valor;
        }, 0);

        setSum(sum);
        setSaldo(sum - saldo);
    };

    const onSetItem = (_id) => {
        setId(_id);
        onToggleModal(true);
    };

    const onBack = () => {
        router.visit("/recaudos");
    };

    const onPrint = () => {
        window.print();
    };

    const goToPDF = () => {
        // window.location.href = "/recaudos/pdf/" + factura.id;

        forcePrint("/recaudos/pdf/" + factura.id);
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
                    Recaudos
                </h2>
            }
        >
            <Head title="Recaudos" />

            <div className="py-12">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg p-6">
                        <form>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel value="Ord. Compra" />

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
                                        value={factura.cliente?.nombre}
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
                                        value="Valor Total"
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
                                        value="Saldo"
                                    />

                                    <TextInput
                                        type="text"
                                        value={toCurrency(saldo)}
                                        className="mt-1 block w-full"
                                        readOnly={true}
                                    />
                                </div>
                            </div>
                        </form>
                    </div>

                    <div className="flex items-center justify-end mt-4 mb-4  no-print">
                        <SecondaryButton
                            className="ms-4"
                            onClick={() => onBack()}
                        >
                            Atras
                        </SecondaryButton>

                        <PrimaryButton
                            className="ms-4"
                            onClick={() => onToggleModal(true)}
                        >
                            Agregar
                        </PrimaryButton>
                    </div>

                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table
                            data={list}
                            links={[]}
                            onEdit={() => {}}
                            onRow={() => {}}
                            titles={titles}
                            actions={[]}
                        />
                    </div>

                    <div className="flex items-center justify-end mt-4 mb-4 no-print">
                    {/*
                        <SecondaryButton className="ms-4" onClick={onPrint}>
                            Imprimir
                        </SecondaryButton>
                    */}
                        <PrimaryButton className="ms-4 me-3" onClick={goToPDF}>
                            PDF
                        </PrimaryButton>

                        <SecondaryButton
                            className="ms-4"
                            onClick={() => goToQR("/recaudos/qr/" + factura.id)}
                        >
                            QR
                        </SecondaryButton>
                    </div>
                </div>
            </div>

            <Modal show={show} closeable={true} title="Agregar Recaudo">
                <Form
                    auth={auth}
                    factura={factura}
                    setIsOpen={onToggleModal}
                    onReload={onReload}
                    id={id}
                    sum={sum}
                    saldo={saldo}
                />
            </Modal>
        </AuthenticatedLayout>
    );
};
