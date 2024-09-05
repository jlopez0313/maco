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
import TextInput from "@/Components/Form/TextInput";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";

export default ({ auth, q, tipoDocumentos, contacts, tipoClientes, departamentos, responsabilidades }) => {
    const {
        data,
        meta: { links },
    } = contacts;

    const titles = [
        "Tipo Documento",
        "Responsabilidad Fiscal",
        "Documento",
        "Nombre",
        "Comercio",
        "Matrícula",
        "Departamento",
        "Ciudad",
        "Dirección",
        "Celular",
        "Correo",
        "Tipo",
    ];

    const [search, setSearch] = useState(q);
    const [action, setAction] = useState("");
    const [adminModal, setAdminModal] = useState(false);
    const [id, setId] = useState(null);
    const [list, setList] = useState([]);
    const [show, setShow] = useState(false);

    const onSetList = () => {
        const _list = data.map((item) => {
            return {
                id: item.id,
                tipo_doc: item.tipo_doc?.tipo || "-",
                responsabilidad: item.responsabilidad?.descripcion || "-",
                documento: `${item.documento}-${item.dv}`,
                nombre: item.nombre || '-',
                comercio: item.comercio || '-',
                matricula: item.matricula || '-',
                departamento: item.ciudad?.departamento?.departamento || "-",
                ciudad: item.ciudad?.ciudad || "-",
                direccion: item.direccion || '-',
                celular: item.celular || '-',
                correo: item.correo || '-',
                tipo: item.tipo?.tipo || "-",
            };
        });

        setList(_list);
    };

    const onSetAdminModal = (_id, action) => {
        setId(_id);
        setAdminModal(true);
        setAction(action);
    };

    const onConfirm = async ({ data }) => {
        if (action == "edit") {
            setAdminModal(false);
            onGoToEdit( data )
        } else {
            onTrash(data);
        }
    };

    const onTrash = async (data) => {
        if (data) {
            await axios.delete(`/api/v1/clientes/${id}`);
            onReload();
        }
    };

    const onToggleModal = (isShown) => {
        if (!isShown) {
            setId(null);
        }
        setShow(isShown);
    };

    const onGoToCreate = () => {
        onToggleModal(false);

        router.visit('/clientes/create');
    };

    const onGoToEdit = (data) => {
        router.visit(`/clientes/edit/${id}`);
    };

    const onReload = () => {
        onToggleModal(false);

        router.visit(window.location.pathname);
    };

    const onSearch = () => {
        onToggleModal(false);

        router.visit(window.location.pathname + "?q=" + search);
    };

    useEffect(() => {
        onSetList();
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Clientes
                </h2>
            }
        >
            <Head title="Clientes" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

                        <PrimaryButton
                            onClick={() => onGoToCreate()}
                        >
                            Agregar
                        </PrimaryButton>
                    </div>

                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table
                            data={list}
                            links={links}
                            onEdit={(evt) => onSetAdminModal(evt, "edit")}
                            onTrash={(evt) => onSetAdminModal(evt, "trash")}
                            titles={titles}
                            actions={["edit", "trash"]}
                        />
                    </div>

                    <Pagination links={links} />
                </div>
            </div>

            <AdminModal
                title={action}
                show={adminModal}
                setIsOpen={setAdminModal}
                onConfirm={onConfirm}
            ></AdminModal>
        </AuthenticatedLayout>
    );
};
