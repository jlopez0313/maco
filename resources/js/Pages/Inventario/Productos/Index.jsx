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
import { AdminModal } from "@/Components/AdminModal";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import { toCurrency } from "@/Helpers/Numbers";
import TextInput from "@/Components/Form/TextInput";

export default ({ auth, q, inventario, impuestos, retenciones, contacts, colores, medidas, unidades_medida }) => {
    const {
        data,
        meta: { links },
    } = contacts;

    const titles = [
        "Artículo",
        "Referencia",
        "Unidad de Medida",
        "Color",
        "Medida",
        "Cantidad",
        "Precio Costo",
    ];

    const [search, setSearch] = useState(q);
    const [action, setAction] = useState("");
    const [adminModal, setAdminModal] = useState(false);
    const [id, setId] = useState(null);
    const [show, setShow] = useState(false);
    const [list, setList] = useState([]);

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
            await axios.delete(`/api/v1/productos/${id}`);
            onReload();
        }
    };

    const onToggleModal = (isShown) => {
        if (!isShown) {
            setId(null);
        }
        onGoToForm();
    };

    const onGoToForm = () => {

        if ( id ) {
            router.visit('/inventario/modify/' + inventario.id + '/' + id );
        } else {
            router.visit('/inventario/add/' + inventario.id );
        }
    }

    const onReload = () => {
        onToggleModal(false);

        router.visit(window.location.pathname);
    };

    const onSearch = () => {
        onToggleModal(false);

        router.visit(window.location.pathname + "?q=" + search);
    };

    const onBack = () => {
        router.visit('/inventario');
    };

    const onSetList = () => {
        const _list = data.map((item) => {
            return {
                id: item.id,
                articulo: item.inventario?.articulo || "",
                referenia: item.referencia,
                unidad_medida: item.unidad_medida?.descripcion || "",
                color: item.color?.color || "",
                medida: item.medida?.medida || "",
                cantidad: item.cantidad,
                precio: toCurrency(item.precio || 0),
            };
        });

        setList(_list);
        setShow(!q && _list.length == 0);
    };

    useEffect(() => {
        onSetList();
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Detalle de Inventario
                </h2>
            }
        >
            <Head title="Inventario" />

            <div className="py-12">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between mt-4 mb-6">
                        <div className="flex items-center">
                            <TextInput
                                placeholder="Buscar..."
                                id="nombre"
                                type="text"
                                name="nombre"
                                className="mt-1 block w-full"
                                autoComplete="nombre"
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                            />

                            <PrimaryButton
                                className="ms-4"
                                onClick={() => onSearch()}
                            >
                                Buscar
                            </PrimaryButton>
                        </div>

                        <div className="flex items-center">
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
                    </div>

                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table
                            data={list}
                            links={links}
                            onRow={(evt) => onSetAdminModal(evt, "edit")}
                            onEdit={(evt) => onSetAdminModal(evt, "edit")}
                            onTrash={(evt) => onSetAdminModal(evt, "trash")}
                            titles={titles}
                            actions={["edit", "trash"]}
                        />
                    </div>
                </div>
            </div>

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
