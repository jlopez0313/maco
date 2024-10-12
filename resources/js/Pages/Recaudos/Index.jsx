import React, { useEffect, useState } from "react";
// import Layout from '@/Components/Layout';
import Icon from "@/Components/Icon";
// import SearchFilter from '@/Shared/SearchFilter';

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import Pagination from "@/Components/Table/Pagination";
import Table from "@/Components/Table/Table";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import { toCurrency } from "@/Helpers/Numbers";
import TextInput from "@/Components/Form/TextInput";

export default ({ auth, q, contacts }) => {
    const {
        data,
        meta: { links },
    } = contacts;

    const titles = [
        "Ord. Compra",
        "Cliente",
        "Valor Total",
        "Saldo",
        "Fecha de Creación",
    ];

    const [search, setSearch] = useState(q);
    const [list, setList] = useState([]);

    const onSetList = () => {
        const valor = data.map((item) => {
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

        const cobros = data.map((item) => {
            return item.recaudos.reduce((sum, det) => sum + det.valor, 0) || 0;
        });

        const _list = data.map((item, idx) => {
            return {
                id: item.id,
                "Ord. Compra": item.id,
                cliente: item.cliente?.nombre,
                valor: toCurrency(valor[idx] || 0),
                saldo: toCurrency((valor[idx] || 0) - (cobros[idx] || 0)),
                fecha: item.created_at,
            };
        });

        setList(_list);
    };

    const onSearch = (id) => {
        router.get(`recaudos/edit/${id}`);
    };

    const onFilter = () => {
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
                    Recaudos
                </h2>
            }
        >
            <Head title="Recaudos" />

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
                                onClick={() => onFilter()}
                            >
                                Buscar
                            </PrimaryButton>
                        </div>
                    </div>

                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table
                            data={list}
                            links={links}
                            onSearch={onSearch}
                            onEdit={() => {}}
                            onRow={() => {}}
                            actions={["search"]}
                            titles={titles}
                        />
                    </div>

                    <Pagination links={links} />
                </div>
            </div>
        </AuthenticatedLayout>
    );
};
