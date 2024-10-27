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
    estados
}) => {

    const [id, setId] = useState(null);
    const [tab, setTab] = useState("general");
    const [show, setShow] = useState(false);
    const [adminModal, setAdminModal] = useState(false);
    const [action, setAction] = useState("");
    const [list, setList] = useState([]);

    const titles = [
        "Usuario",
        "Password",
        "Estado",
    ];

    const onSetList = async () => {

        const { data: contactos } = await axios.get(`/api/v1/credenciales`);
        const lista = [ ...contactos.data ]
        
        const _list = lista.map((item, idx) => {
            return {
                id: item.id,
                username: item.username,
                password: item.password,
                estado_label: item.estado_label
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
            await axios.delete(`/api/v1/credenciales/${id}`);
            onReload();
        }
    };

    const onReload = () => {
        onToggleModal(false);
        onSetList();
    };

    useEffect(() => {
        onSetList();
    }, []);

    return (
        <>
            <div className="pb-12 pt-6">
                <div className="mt-4 mb-6 flex justify-end	">
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

            <Modal show={show} closeable={true} title="Registrar Credenciales">
                <Form
                    id={id}
                    auth={auth}
                    setIsOpen={onToggleModal}
                    onEdit={(evt) => onSetAdminModal(evt, "edit")}
                    onTrash={(evt) => onSetAdminModal(evt, "trash")}
                    estados={estados}
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