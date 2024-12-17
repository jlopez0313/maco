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
import { useCookies } from "react-cookie";

export default ({ auth, q, contacts, proveedores, payments, medios_pago }) => {
    const {
        data,
        meta: { links },
    } = contacts;

    const titles = [
        "Fecha de Creación",
        {
            key: "id",
            title: "Codigo",
        },
        "Proveedor",
        "Forma de Pago",
        "Medio de Pago",
        "Valor Total",
        {
            key: "id",
            title: "Estado",
        }
    ];

    const [cookies, setCookie] = useCookies(["maco"]);

    const [search, setSearch] = useState(q);
    const [action, setAction] = useState("");
    const [adminModal, setAdminModal] = useState(false);
    const [list, setList] = useState([]);
    const [id, setId] = useState(null);
    const [show, setShow] = useState(false);

    const onSetList = () => {

        const sum = data.map((item) => {
            item.detalles.forEach((_item) => {
                let retenciones = 0;

                _item.producto?.impuestos.forEach((impto) => {
                    if (impto.impuesto?.tipo_impuesto == "R") {
                        if (impto.impuesto.tipo_tarifa == "P") {
                            retenciones +=
                                ((_item.precio_venta || 0) *
                                    Number(impto.impuesto.tarifa)) /
                                100;
                        } else if (impto.impuesto.tipo_tarifa == "V") {
                            retenciones += Number(impto.impuesto.tarifa);
                        }
                    }
                });

                _item.total_retenciones = retenciones;
            });

            return (
                item.detalles.reduce(
                    (sum, det) =>
                        sum +
                        det.precio_venta * det.cantidad +
                        det.total_retenciones * det.cantidad,
                    0
                ) || 0
            );
        });

        let _sum = 0;
        let sumFel = 0;
        
        const _list = data.map((item, idx) => {
            _sum +=
                item.forma_pago?.id == 1 && item.estado == "C"
                    ? sum[idx] || 0
                    : 0;
            sumFel +=
                item.forma_pago?.id == 1 && item.estado == "C" && item.prefijo
                    ? sum[idx] || 0
                    : 0;

            return {
                id: item.id,
                fecha: item.created_at,
                codigo: item.prefijo ? "FEL " + item.folio : item.id,
                proveedor: item.proveedor?.nombre || "",
                payment: item.forma_pago?.descripcion || "",
                medio_pago: item.medio_pago?.descripcion || "",
                valor_total: toCurrency(sum[idx] || 0),
                estado_label: item.estado_label || "",
                estado: item.estado || "",
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
            onEdit(id);
        } else if (action == "search") {
            onShow(id)
        } else {
            onTrash(data);
        }
    };

    const onShow = ( id ) => {
        router.visit("/gastos/show/" + id);
    }

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

    const onEdit = (id) => {
        router.get(`/gastos/edit/${id}`);
    };

    const onSearch = () => {
        onToggleModal(false);

        router.visit(window.location.pathname + "?q=" + search);
    };

    const onSort = (field) => {
        const sort = cookies.icon == "asc" ? "desc" : "asc";
        setCookie("sort", field, { path: window.location.pathname });
        setCookie("icon", sort, { path: window.location.pathname });

        router.visit(window.location.pathname);
    };

    const onCheckRoute = ( ) => {
        if( window.location.pathname == '/gastos/comprar' ) {
            onToggleModal(true)
        }
    }

    useEffect(() => {
        onSetList();
        onCheckRoute()
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Compras
                </h2>
            }
        >
            <Head title="Compras" />

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
                            sortIcon={cookies.icon || "down"}
                            onSort={onSort}
                            data={list}
                            links={links}
                            onSearch={(evt) => onShow(evt)}
                            onEdit={(evt) => onSetAdminModal(evt, "edit")}
                            onRow={(evt) => onShow(evt)}
                            onTrash={(evt) => onSetAdminModal(evt, "trash")}
                            titles={titles}
                            actions={["search", "edit", "trash"]}
                        />
                    </div>

                    <Pagination links={links} />
                </div>
            </div>
            <Modal show={show} closeable={true} title="Registrar Compra">
                <Form
                    auth={auth}
                    proveedores={proveedores}
                    payments={payments}
                    medios_pago={medios_pago}
                    setIsOpen={onToggleModal}
                    onEdit={onEdit}
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
