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
import { Form } from "./Productos/Form";
import { AdminModal } from "@/Components/AdminModal";

export default ({ auth, inventario, contacts, colores, medidas }) => {

    const {
        data,
        meta: { links },
    } = contacts;
    
    const {
        data: coloresLst,
    } = colores;
    
    const {
        data: medidasLst,
    } = medidas;
    
    const titles = [
        "Artículo",
        "Referencia",
        "Color",
        "Medida",
        "Cantidad",
        "Precio Costo",
    ];
    
    const [action, setAction] = useState( '' );
    const [adminModal, setAdminModal] = useState( false );
    const [id, setId] = useState(null);
    const [show, setShow] = useState(false);
    const [list, setList] = useState([]);

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
            await axios.delete(`/api/v1/productos/${id}`);
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

    const onSetList = () => {
        const _list = data.map((item) => {
            return {
                id: item.id,
                articulo: item.inventario?.articulo || '',
                referenia: item.referencia,
                color: item.color?.color || '',
                medida: item.medida?.medida || '',
                cantidad: item.cantidad,
                precio: item.precio,
            };
        });

        setList(_list);
        setShow( _list.length == 0 )
    };

    useEffect(() => {
        onSetList();
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Editar Inventario
                </h2>
            }
        >
            <Head title="Inventario" />

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
                </div>
            </div>
            

            <Modal show={show} closeable={true} title="Crear Referencia">
                <Form
                    auth={auth}
                    inventario={inventario}
                    colores={coloresLst}
                    medidas={medidasLst}
                    setIsOpen={onToggleModal}        
                    onReload={onReload}
                    id={id}
                />
            </Modal>

            <AdminModal title={ action } show={adminModal} setIsOpen={setAdminModal} onConfirm={onConfirm}></AdminModal>

        </AuthenticatedLayout>
    );
};
