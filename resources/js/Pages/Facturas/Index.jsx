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

export default ({ auth, tipoClientes, contacts, departments, payments }) => {

    const {
        data: departamentos,
    } = departments;
    
    const {
        data,
        meta: { links },
    } = contacts;

    const titles= [
        'Fecha de Creación',
        'Código',
        'Cliente',
        'Forma de Pago'
    ]

    const [action, setAction] = useState( '' );
    const [adminModal, setAdminModal] = useState( false );
    const [id, setId] = useState(null);
    const [list, setList] = useState([]);
    const [show, setShow] = useState(false);
    
    const onSetList = () => {
        const _list = data.map( item => {
            return {
                id: item.id,
                fecha: item.created_at,
                codigo: item.id,
                cliente: item.cliente?.nombre || '',
                payment: item.forma_pago || ''
            }
        })

        setList( _list );
    }

    const onSetAdminModal = (_id, action) => {
        setId(_id)
        setAdminModal(true)
        setAction( action )
    }

    const onConfirm = async ({ data }) => {
        if ( action == 'edit' ) {
            setAdminModal( false )
            onEdit( id )
        } else {
            onTrash(data)
        }
    }

    const onTrash = async (data) => {
        if ( data ) {
            await axios.delete(`/api/v1/facturas/${id}`);
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

    const onEdit = (id) => {
        router.get( `remisiones/edit/${ id }` )
    }

    const onSearch = (id) => {
        router.get( `remisiones/show/${ id }` )
    }

    useEffect(()=> {
        onSetList()
    }, [])

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Órdenes de Compra
                </h2>
            }
        >
            <Head title="Órdenes de Compra" />

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
                            onSearch={ (evt) => onSearch(evt) }
                            onEdit={ (evt) => onSetAdminModal(evt, 'edit') }
                            onTrash={ (evt) => onSetAdminModal(evt, 'trash') }
                            titles={titles}
                            actions={["search", "edit", "trash"]}
                        />
                    </div>

                    <Pagination links={links} />
                </div>
            </div>

            <Modal show={show} closeable={true} title="Registrar Órden">
                <Form
                    auth={auth}
                    departamentos={departamentos}
                    medidas={[]}
                    origenes={[]}
                    tipoClientes={tipoClientes}
                    payments={payments}
                    setIsOpen={onToggleModal}        
                    onSearch={onSearch}
                    id={id}
                />
            </Modal>

            <AdminModal title={ action } show={adminModal} setIsOpen={setAdminModal} onConfirm={onConfirm}></AdminModal>

        </AuthenticatedLayout>
    );
}
