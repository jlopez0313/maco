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
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import { Cierre } from "./Cierre";

export default ({ auth, q, contacts, departments, payments, medios_pago, clientes }) => {
    const { data: departamentos } = departments;

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
        "Cliente",
        "Forma de Pago",
        "Medio de Pago",
        "Valor Total",
        {
            key: "id",
            title: "Estado",
        },,
    ];

    const [cookies, setCookie] = useCookies(["maco"]);

    const [search, setSearch] = useState(q);
    const [action, setAction] = useState("");
    const [adminModal, setAdminModal] = useState(false);
    const [id, setId] = useState(null);
    const [list, setList] = useState([]);
    const [show, setShow] = useState(false);
    const [showCierre, setShowCierre] = useState(false);
    const [total, setTotal] = useState(0);
    const [fel, setFel] = useState(0);

    const onSetList = () => {
        const sum = data.map((item) => {
                        
            item.detalles.forEach((_item) => {
                let impuestos = 0;

                _item.producto?.impuestos.forEach((impto) => {
                    if (impto.impuesto?.tipo_impuesto == "I") {
                        if (impto.impuesto.tipo_tarifa == "P") {
                            impuestos +=
                                ((_item.precio_venta || 0) *
                                    Number(impto.impuesto.tarifa)) /
                                100;
                        } else if (impto.impuesto.tipo_tarifa == "V") {
                            impuestos += Number(impto.impuesto.tarifa);
                        }
                    }
                });

                _item.total_impuestos = impuestos;
            });
            
            return (
                item.detalles.reduce(
                    (sum, det) =>
                        sum +
                        det.precio_venta * det.cantidad +
                        det.total_impuestos * det.cantidad,
                    0
                ) || 0
            );
        });
        
        let _sum = 0;
        let sumFel = 0;

        const _list = data.map((item, idx) => {
            _sum += item.forma_pago?.id == 1 && item.estado == 'C' ? (sum[idx] || 0) : 0;
            sumFel += item.forma_pago?.id == 1 && item.estado == 'C' && item.prefijo ? (sum[idx] || 0) : 0;

            return {
                id: item.id,
                fecha: item.created_at,
                codigo: item.prefijo ? 'FEL ' + item.folio : item.id,
                cliente: item.cliente?.nombre || "",
                payment: item.forma_pago?.descripcion || "",
                medio_pago: item.medio_pago?.descripcion || "",
                valor_total: toCurrency(sum[idx] || 0),
                estado_label: item.estado_label || "",
                estado: item.estado || "",
            };
        });

        setFel(sumFel);
        setTotal(_sum);
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
        } else {
            onTrash(data);
        }
    };

    const onTrash = async (data) => {
        if (data) {
            await axios.delete(`/api/v1/facturas/${id}`);
            onReload();
        }
    };

    const onToggleCierre = (isShown) => {
        setShowCierre(isShown);
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

    const onFilter = () => {
        onToggleModal(false);

        router.visit(window.location.pathname + "?q=" + search);
    };

    const onEdit = (id) => {
        router.get(`remisiones/edit/${id}`);
    };

    const onSearch = (id) => {
        router.get(`remisiones/show/${id}`);
    };

    const onSort = (field) => {
        const sort = cookies.icon == "asc" ? "desc" : "asc";
        setCookie("sort", field, { path: window.location.pathname });
        setCookie("icon", sort, { path: window.location.pathname });

        router.visit(window.location.pathname);
    };

    useEffect(() => {
        onSetList();
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Ventas
                </h2>
            }
        >
            <Head title="Ventas" />

            <div className="py-12">
                <div className="max-w-5xl mx-auto sm:px-6 lg:px-8">
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
                                onClick={() => onFilter()}
                            >
                                Buscar
                            </PrimaryButton>
                        </div>

                        <div className="flex items-center">

                        <span className="font-bold mt-5 mx-5 mb-5 flex bg-white px-3 py-2"> Facturación Electrónica: { toCurrency(fel)}  </span>
                        
                        <SecondaryButton onClick={() => onToggleCierre(true)} className="me-4">
                            Cuadre de Caja
                        </SecondaryButton>
                        
                        <PrimaryButton onClick={() => onToggleModal(true)}>
                            Agregar
                        </PrimaryButton>
                        </div>

                    </div>

                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table
                            sortIcon={cookies.icon || "down"}
                            onSort={onSort}
                            data={list}
                            links={links}
                            onSearch={(evt) => onSearch(evt)}
                            onEdit={(evt) => onEdit(evt)}
                            onRow={(evt) => onEdit(evt)}
                            onTrash={(evt) => onSetAdminModal(evt, "trash")}
                            titles={titles}
                            actions={["search", "edit", "trash"]}
                        />
                    </div>

                    <Pagination links={links} />

                    <span className="font-bold mt-10 flex"> Total Ventas Contado: {toCurrency(total)}  </span>
                </div>
            </div>

            <Modal show={show} closeable={true} title="Registrar Venta">
                <Form
                    auth={auth}
                    departamentos={departamentos}
                    medidas={[]}
                    origenes={[]}
                    payments={payments}
                    clientes={clientes}
                    medios_pago={medios_pago}
                    setIsOpen={onToggleModal}
                    onEdit={onEdit}
                    id={id}
                />
            </Modal>

            <Modal show={showCierre} closeable={true} title="Cuadre de Caja">
                <Cierre
                    auth={auth}
                    setIsOpen={onToggleCierre}
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
