import React, { useState } from "react";
import NavLink from "@/Components/NavLink";
import { AdminModal } from "@/Components/AdminModal";
import { router } from "@inertiajs/react";

export default ({ auth, id }) => {

    const [adminModal, setAdminModal] = useState(false);

    const onSetAdminModal = () => {
        setAdminModal(true);
    };

    const onConfirm = async ({ data }) => {
        setAdminModal(false);
        onEdit(id);
    };

    const onEdit = (id) => {
        router.get(`/clientes/edit/${id}`);
    };

    return (
        <>
            <h2 className="font-semibold text-2xl text-gray-800 leading-tight">
                {" "}
                Ooops....{" "}
            </h2>
            No encontramos un contacto <b>principal</b> para el Cliente.
            <br />
            Por favor registra uno &nbsp;
            <span
                className="!font-bold !text-md !bg-blue-300 rounded cursor-pointer"
                onClick={onSetAdminModal}
            >
                aquí
            </span>

            <AdminModal
                title="edit"
                show={adminModal}
                setIsOpen={setAdminModal}
                onConfirm={onConfirm}
            ></AdminModal>
        </>
    );
};
