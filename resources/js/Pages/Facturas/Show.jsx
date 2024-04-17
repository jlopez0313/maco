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
import { Form } from "./Detalle/Form";
import InputLabel from "@/Components/Form/InputLabel";
import TextInput from "@/Components/Form/TextInput";
import { AdminModal } from "@/Components/AdminModal";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import { toCurrency } from "@/Helpers/Numbers";

export default ({ auth, factura }) => {


    const data = factura.detalles;

    const titles = [
        "Artículo",
        "Referencia",
        "Color",
        "Medida",
        "Cantidad",
        "Precio Venta",
    ];

    const [action, setAction] = useState( '' );
    const [adminModal, setAdminModal] = useState( false );
    const [id, setId] = useState(null);
    const [show, setShow] = useState(false);
    const [list, setList] = useState([]);
    const [sum, setSum] = useState(0);

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
            await axios.delete(`/api/v1/detalles/${id}`);
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

    const goToPDF = () => {
        window.location.href = '/remisiones/pdf/' + factura.id;
    }

    const goToQR = () => {
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

        const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left = (width - 700) / 2 / systemZoom + dualScreenLeft
        const top = (height - 500) / 2 / systemZoom + dualScreenTop

        window.open(
            '/remisiones/qr/' + factura.id,
            "ModalPopUp",
            "toolbar=no," +
            "scrollbars=no," +
            "location=yes," +
            "statusbar=no," +
            "menubar=no," +
            "resizable=0," +
            "width=750," +
            "height=750," +
            "left=" + left + "," +
            "top=" + top + ""    
        );
    }

    const onSetList = () => {
        const _list = data.map((item) => {
            return {
                id: item.id,
                articulo: item.producto?.inventario?.articulo || '',
                referenia: item.producto?.referencia || '',
                color: item.producto?.color?.color || '',
                medida: item.producto?.medida?.medida || '',
                cantidad: item.cantidad,
                precio: toCurrency( item.precio_venta || 0 ),
            };
        });

        setList(_list);
        setShow( _list.length == 0 )
    };

    const onSetSum = () => {
        const sum = data.reduce( (sum, item) => {
            return sum + (item.precio_venta * item.cantidad);
        }, 0);

        setSum( toCurrency( sum ) )
    }

    const onBack = () => {
        router.visit('/remisiones');
    }

    useEffect(() => {
        onSetList();
        onSetSum();
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Detalle Órden de Compra
                </h2>
            }
        >
            <Head title="Detalle Órden de Compra" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div className="flex items-center justify-end mt-4 mb-4">
                        <SecondaryButton
                            className="ms-4"
                            onClick={() => onBack()}
                        >
                            Atras
                        </SecondaryButton>
                    </div>

                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg p-6">
                        <form>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <InputLabel value="Documento" />

                                    <TextInput
                                        type="text"
                                        value={factura.id}
                                        className="mt-1 block w-full"
                                        readOnly={true}
                                    />
                                </div>
                                
                                <div>
                                    <InputLabel value="Cliente" />

                                    <TextInput
                                        type="text"
                                        value={factura.cliente.nombre}
                                        className="mt-1 block w-full"
                                        readOnly={true}
                                    />
                                </div>
                                
                                <div>
                                    <InputLabel htmlFor="fecha" value="Fecha" />

                                    <TextInput
                                        type="text"
                                        value={factura.created_at}
                                        className="mt-1 block w-full"
                                        readOnly={true}
                                    />
                                </div>
                                
                                <div>
                                    <InputLabel htmlFor="ciudad" value="Valor Total" />
                                    
                                    <TextInput
                                        type="text"
                                        value={sum}
                                        className="mt-1 block w-full"
                                        readOnly={true}
                                    />
                                </div>
                                
                            </div>
                        </form>
                    </div>


                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table
                            data={list}
                            links={[]}
                            titles={titles}
                            actions={[]}
                        />
                    </div>
                    
                    <div className="flex items-center justify-end mt-4 mb-4">
                        <PrimaryButton
                            className="ms-4 me-3"
                            onClick={goToPDF}
                        >
                            PDF
                        </PrimaryButton>

                        <PrimaryButton
                            className="ms-4"
                            onClick={goToQR}
                        >
                            QR
                        </PrimaryButton>

                    </div>

                </div>
            </div>
            
        </AuthenticatedLayout>
    );
};
