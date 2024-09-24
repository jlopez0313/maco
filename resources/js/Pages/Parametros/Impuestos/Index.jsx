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
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import { AdminModal } from "@/Components/AdminModal";
import { useCookies } from 'react-cookie'

export default ({ auth, contacts, impuestos_tarifas, impuestos_tipos }) => {
    const {
        data,
        meta: { links },
    } = contacts;

    const titles = [
        {
            key:'codigo',
            title: 'Codigo'
        },
        "Concepto",
        "Tarifa",
        'Tipo de Tarifa',
        'Tipo de Impuesto'
    ];

    const [cookies, setCookie] = useCookies(['maco'])

    const [action, setAction] = useState("");
    const [adminModal, setAdminModal] = useState(false);
    const [list, setList] = useState([]);
    const [id, setId] = useState(null);
    const [show, setShow] = useState(false);

    const onSetList = () => {
        const _list = data.map((item) => {
            return {
                id: item.id,
                codigo: item.codigo,
                concepto: item.concepto,
                tarifa: item.tarifa,
                tipo_tarifa: item.tipo_tarifa_label,
                tipo_impuesto: item.tipo_impuesto_label,
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
            await axios.delete(`/api/v1/impuestos/${id}`);
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
        setAdminModal(false);

        router.visit(window.location.pathname);
    };

    const onBack = () => {
        history.back();
    };
    
    const onSort = (field) => {
        const sort = cookies.icon == 'asc' ? 'desc' : 'asc';
        setCookie('sort', field, { path: window.location.pathname })
        setCookie('icon', sort, { path: window.location.pathname })

        router.visit(window.location.pathname)
    }

    useEffect(() => {
        onSetList();
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Impuestos
                </h2>
            }
        >
            <Head title="Impuestos" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="flex items-center justify-end mt-4 mb-4">
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
                            sortIcon={cookies.icon || 'down'}
                            onSort={onSort}
                            data={list}
                            links={links}
                            onEdit={(evt) => onSetAdminModal(evt, "edit")}
                            onTrash={(evt) => onSetAdminModal(evt, "trash")}
                            titles={titles}
                            actions={["edit"]}
                        />
                    </div>

                    <Pagination links={links} />
                </div>
            </div>
            <Modal show={show} closeable={true} title="Crear Impuestos">
                <Form
                    setIsOpen={onToggleModal}
                    onReload={onReload}
                    tipos_tarifas={impuestos_tarifas}
                    tipos_impuestos={impuestos_tipos}
                    id={id}
                />
            </Modal>

            <AdminModal
                title={action}
                show={adminModal}
                setIsOpen={setAdminModal}
                onConfirm={onConfirm}
            ></AdminModal>
        </AuthenticatedLayout>
    );
};
