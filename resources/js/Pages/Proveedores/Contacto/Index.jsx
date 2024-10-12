import React, { useEffect, useState } from "react";
// import Layout from '@/Components/Layout';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router } from "@inertiajs/react";
import Form from "./Form";
import Modal from "@/Components/Modal";
import Table from "@/Components/Table/Table";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import { AdminModal } from "@/Components/AdminModal";

export default ({
    auth,
    S_N,
    tipoDocumentos,
    tipoClientes,
    departamentos,
    responsabilidades,
    proveedor,
}) => {

    const [proveedoresId, setEmpresasId] = useState(proveedor?.id || null);
    const [id, setId] = useState(null);
    const [tab, setTab] = useState("general");
    const [show, setShow] = useState(false);
    const [adminModal, setAdminModal] = useState(false);
    const [action, setAction] = useState("");
    const [list, setList] = useState([]);

    const titles = [
        "Nombre",
        "Correo",
        "Celular",
        "Contacto Principal"
    ];

    const onSetList = async () => {

        const { data: contactos } = await axios.get(`/api/v1/contactos/proveedor/${proveedoresId}`);
        const lista = [ ...contactos.data ]
        
        const _list = lista.map((item, idx) => {
            return {
                id: item.id,
                nombre: item.nombre,
                correo: item.correo,
                celular: item.celular,
                principal: item.principal_label
            };
        });

        setList(_list);
    };

    const onToggleModal = (isShown) => {
        if (!isShown) {
            setId(null);
        }
        setShow(isShown);
    };

    const onSetAdminModal = (_id, action) => {
        setId(_id);
        setAdminModal(true);
        setAction(action);
    };

    const onConfirm = async ({ data }) => {
        
        if (action == "edit") {
            onToggleModal(true);
        } else {
            onTrash(data);
        }

        setAdminModal(false);

    };

    const onTrash = async (data) => {
        if (data) {
            await axios.delete(`/api/v1/contactos/${id}`);
            onReload();
        }
    };

    const onReload = () => {
        onToggleModal(false);
        onSetList();
    };

    useEffect(() => {
        onSetList();
    }, [proveedoresId]);

    return (
        <>
            <div className="pb-12">
                <div className="mb-6 flex justify-end	">
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
                        onEdit={(evt) => onSetAdminModal(evt, "edit")}
                        onRow={(evt) => onSetAdminModal(evt, "edit")}
                        onTrash={(evt) => onSetAdminModal(evt, "trash")}
                        titles={titles}
                        actions={["edit", "trash"]}
                    />
                </div>
            </div>

            <Modal show={show} closeable={true} title="Registrar Contacto">
                <Form
                    auth={auth}
                    tipoDocumentos={tipoDocumentos}
                    tipoClientes={tipoClientes}
                    departamentos={departamentos}
                    responsabilidades={responsabilidades}
                    setIsOpen={onToggleModal}
                    onEdit={(evt) => onSetAdminModal(evt, "edit")}
                    onTrash={(evt) => onSetAdminModal(evt, "trash")}
                    id={id}
                    S_N={S_N}
                    proveedoresId={proveedoresId}
                    onReload={onReload}
                />
            </Modal>

            <AdminModal
                auth={auth}
                title={action}
                show={adminModal}
                setIsOpen={setAdminModal}
                onConfirm={onConfirm}
            ></AdminModal>
        </>
    );
};
