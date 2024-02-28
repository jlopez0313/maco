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
import { AdminModal } from "@/Components/AdminModal";

export default ({ auth, tipos_doc, contacts, tipoClientes, departamentos }) => {

    const {
        data,
        meta: { links },
    } = contacts;

    const titles = [
        "Tipo Documento",
        "Documento",
        "Nombre",
        "Departamento",
        "Ciudad",
        "Dirección",
        "Celular",
    ];

    const [action, setAction] = useState( '' );
    const [adminModal, setAdminModal] = useState( false );
    const [id, setId] = useState(null);
    const [list, setList] = useState([]);
    const [show, setShow] = useState(false);

    const onSetList = () => {
        const _list = data.map((item) => {
            return {
                id: item.id,
                tipo_doc: item.tipo_doc_label,
                documento: item.documento,
                nombre: item.nombre,
                departamento: item.ciudad?.departamento?.departamento || "",
                ciudad: item.ciudad?.ciudad || "",
                direccion: item.direccion,
                celular: item.celular,
            };
        });

        setList(_list);
    };

    const onSetAdminModal = (_id, action) => {
        setId(_id)
        setAdminModal(true)
        setAction( action )
    }

    const onConfirm = async ({ data }) => {
        if ( action == 'edit' ) {
            setAdminModal( false )
            onToggleModal( true )
        } else {
            onTrash(data)
        }
    }

    const onTrash = async (data) => {
        if ( data ) {
            await axios.delete(`/api/v1/proveedores/${id}`);
            onReload()
        }
    }

    const onToggleModal = (isShown) => {
        if ( !isShown ) {
            setId(null)
        }
        setShow(isShown);
    };

    const onReload = () => {
        onToggleModal(false);

        router.visit(window.location.pathname);
    }

    useEffect(() => {
        onSetList();
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Proveedores
                </h2>
            }
        >
            <Head title="Proveedores" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="flex items-center justify-end mt-4 mb-4">
                        <PrimaryButton
                            className="ms-4"
                            onClick={() => onToggleModal(true)}
                        >
                            Agregar
                        </PrimaryButton>
                    </div>

                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Table
                            data={list}
                            links={links}
                            onEdit={ (evt) => onSetAdminModal(evt, 'edit') }
                            onTrash={ (evt) => onSetAdminModal(evt, 'trash') }
                            titles={titles}
                            actions={["edit", "trash"]}
                        />
                    </div>

                    <Pagination links={links} />
                </div>
            </div>

            <Modal show={show} closeable={true} title="Crear Cliente">
                <Form
                    tipos_doc={tipos_doc}
                    departamentos={departamentos}
                    tipoClientes={tipoClientes}
                    setIsOpen={onToggleModal}        
                    onReload={onReload}
                    id={id}
                />
            </Modal>

            <AdminModal show={adminModal} setIsOpen={setAdminModal} onConfirm={onConfirm}></AdminModal>

        </AuthenticatedLayout>
    );
};
