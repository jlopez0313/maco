import React, { useEffect, useState } from "react";
// import Layout from '@/Components/Layout';
import Icon from "@/Components/Icon";
// import SearchFilter from '@/Shared/SearchFilter';

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import Pagination from "@/Components/Table/Pagination";
import Table from "@/Components/Table/Table";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import Modal from "@/Components/Modal";
import { Form } from "./Form";
import { AdminModal } from "@/Components/AdminModal";
import { toCurrency } from "@/Helpers/Numbers";
import TextInput from "@/Components/Form/TextInput";

export default ({ auth, q, contacts, clientes, conceptos, origenes }) => {
    const {
        data,
        meta: { links },
    } = contacts;

    const titles = [
        "Fecha",
        "Recibo",
        "Cliente",
        "Origen",
        "Concepto",
        "Valor",
    ];

    const [search, setSearch] = useState(q);
    const [action, setAction] = useState("");
    const [adminModal, setAdminModal] = useState(false);
    const [list, setList] = useState([]);
    const [id, setId] = useState(null);
    const [show, setShow] = useState(false);

    const onSetList = () => {
        const _list = data.map((item) => {
            return {
                id: item.id,
                fecha: item.created_at,
                recibo: item.id,
                cliente: item.cliente?.nombre || "",
                origen: item.origen_label,
                concepto: item.concepto?.concepto || "",
                valor: toCurrency(item.valor || 0),
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
            onToggleModal(true);
        } else {
            onTrash(data);
        }
    };

    const onTrash = async (data) => {
        if (data) {
            await axios.delete(`/api/v1/gastos/${id}`);
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
                    Gastos
                </h2>
            }
        >
            <Head title="Gastos" />

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
                            links={links}
                            onEdit={(evt) => onSetAdminModal(evt, "edit")}
                            onRow={(evt) => onSetAdminModal(evt, "edit")}
                            onTrash={(evt) => onSetAdminModal(evt, "trash")}
                            titles={titles}
                            actions={["edit", "trash"]}
                        />
                    </div>

                    <Pagination links={links} />
                </div>
            </div>
            <Modal show={show} closeable={true} title="Crear Gastos">
                <Form
                    auth={auth}
                    clientes={clientes}
                    conceptos={conceptos}
                    origenes={origenes}
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
