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
import Select from "@/Components/Form/Select";
import { notify } from "@/Helpers/Notify";

export default ({ auth, factura }) => {
    const data = factura.detalles;

    const titles = [
        "Artículo",
        "Referencia",
        "Unidad de Medida",
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
    const [desea, setDesea] = useState('');

    const onSetAdminModal = (_id, action) => {
        setId(_id);
        // setAdminModal(true);
        setAction(action);
        onToggleModal(true);

    };

    const onConfirm = async ({ data }) => {
        if (action == "edit") {
            setAdminModal(false);
            onToggleModal(true);
        } else {
            onTrash(data);
        }
    };

    const onTrash = async (id) => {
        await axios.delete(`/api/v1/detalles/${id}`);
        onReload();
        
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

    const onRegistrar = async () => {
        try {
            const data = {
                updated_by: auth.user.id,
                desea
            };
            await axios.post(`/api/v1/facturas/registrar/${factura.id}`, data);
            onReload();
    
            router.visit("/remisiones/show/" + factura.id);
        } catch (e) {
            notify('error',e.response?.data?.errors.join(','))
        }
    };

    const onSetList = () => {
        const _list = data.map((item) => {
            let impuestos = 0;

            item.producto?.impuestos.forEach((impto) => {
                if (impto.impuesto.tipo_impuesto == "I") {
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
                unidad_medida: item.producto?.unidad_medida?.descripcion || "",
                color: item.producto?.color?.color || "",
                medida: item.producto?.medida?.medida || "",
                cantidad: item.cantidad,
                precio: toCurrency(item.precio_venta),
                impuestos: toCurrency(impuestos),
                total_impuestos: toCurrency(impuestos * item.cantidad),
                total: toCurrency(
                    impuestos * item.cantidad +
                        (item.precio_venta || 0) * item.cantidad
                ),
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
                if (impto.impuesto.tipo_impuesto == "I") {
                    if (impto.impuesto.tipo_tarifa == "P") {
                        impuestos +=
                            (((item.precio_venta || 0) *
                                Number(impto.impuesto.tarifa)) /
                                100) *
                            item.cantidad;
                    } else if (impto.impuesto.tipo_tarifa == "V") {
                        impuestos +=
                            Number(impto.impuesto.tarifa) * item.cantidad;
                    }
                }
            });
        });

        setImptos(impuestos);

    };

    const onBack = () => {
        router.visit("/remisiones");
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
                    Editar Venta
                </h2>
            }
        >
            <Head title="Ventas" />

            <div className="py-12">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
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

                    <div className="flex items-center justify-end mt-4 mb-4">
                        <SecondaryButton
                            className="ms-4"
                            onClick={() => onBack()}
                        >
                            Atras
                        </SecondaryButton>
                        {factura.estado != "C" && (
                            <PrimaryButton
                                className="ms-4"
                                onClick={() => onToggleModal(true)}
                            >
                                Agregar
                            </PrimaryButton>
                        )}
                    </div>

                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table
                            data={list}
                            links={[]}
                            onEdit={(evt) => onSetAdminModal(evt, "edit")}
                            onRow={(evt) => onSetAdminModal(evt, "edit")}
                            onTrash={(evt) => onTrash(evt)}
                            titles={titles}
                            actions={[
                                factura.estado != "C" ? "edit" : "",
                                factura.estado != "C" ? "trash" : "",
                            ]}
                        />
                    </div>

                    <div className="flex items-center justify-end mt-4 mb-4 no-print">
                        <InputLabel
                            htmlFor="desea_factura"
                            value="Desea Factura Electrónica?"
                        />

                        <Select
                            id="desea_factura"
                            name="desea_factura"
                            className="mt-1 block w-full"
                            onChange={ (e) => { setDesea(e.target.value) }}
                        >
                            <option value="S"> SI </option>
                            <option value="N"> NO </option>
                        </Select>
                    </div>

                    <div className="flex items-center justify-end mt-4 mb-4">
                        {factura.estado != "C" && desea && (
                            <PrimaryButton
                                className="ms-4"
                                onClick={() => onRegistrar(true)}
                                disabled={!list.length}
                            >
                                Registrar
                            </PrimaryButton>
                        )}
                    </div>
                </div>
            </div>

            <Modal show={show} closeable={true} title="Agregar Producto">
                <Form
                    auth={auth}
                    factura={factura}
                    setIsOpen={onToggleModal}
                    onReload={onReload}
                    id={id}
                />
            </Modal>

            <AdminModal
                auth={auth}
                title={action}
                show={adminModal}
                setIsOpen={setAdminModal}
                onConfirm={onConfirm}
            ></AdminModal>
        </AuthenticatedLayout>
    );
};
