import React, { useEffect, useState } from "react";
// import Layout from '@/Components/Layout';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import Informacion from "./Informacion/Index";
import Contacto from "./Contacto/Index";
import Resoluciones from "./Resoluciones/Index";
import Consecutivo from "./Consecutivo/Index";
import Credenciales from "./Credenciales/Index";

export default ({
    auth,
    tenant_id,
    tipoDocumentos,
    tipoEmpresas,
    departamentos,
    responsabilidades,
    estados_resoluciones,
    estados,
    S_N,
    contact,
}) => {
    const [tab, setTab] = useState("general");

    useEffect(() => {

    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Mi Empresa
                </h2>
            }
        >
            <Head title="Mi Empresa" />

            <div className="pb-12 pt-6">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg p-6 mt-6">
                        <div className="flex justify-around">
                            <div
                                className={`cursor-pointer items-center font-bold ${ tab == 'general' ? 'underline' : ''}`}
                                onClick={() => setTab("general")}
                            >
                                Información General
                            </div>

                            <div
                                className={`cursor-pointer items-center font-bold ${ tab == 'contacto' ? 'underline' : ''}`}
                                onClick={() => setTab("contacto")}
                            >
                                Contáctos
                            </div>

                            <div
                                className={`cursor-pointer items-center font-bold ${ tab == 'resoluciones' ? 'underline' : ''}`}
                                onClick={() => setTab("resoluciones")}
                            >
                                Resoluciones de Facturación
                            </div>

                            <div
                                className={`cursor-pointer items-center font-bold ${ tab == 'consecutivo' ? 'underline' : ''}`}
                                onClick={() => setTab("consecutivo")}
                            >
                                Consecutivo de Factura
                            </div>

                            <div
                                className={`cursor-pointer items-center font-bold ${ tab == 'credenciales' ? 'underline' : ''}`}
                                onClick={() => setTab("credenciales")}
                            >
                                Credenciales
                            </div>
                        </div>
                    </div>

                    {tab == "general" && (
                        <Informacion
                            auth={auth}
                            tenant_id={tenant_id}
                            tipoDocumentos={tipoDocumentos}
                            tipoEmpresas={tipoEmpresas}
                            departamentos={departamentos}
                            responsabilidades={responsabilidades}
                            contact={contact}
                        />
                    )}

                    {tab == "contacto" && (
                        <Contacto
                            auth={auth}
                            tipoDocumentos={tipoDocumentos}
                            tipoEmpresas={tipoEmpresas}
                            departamentos={departamentos}
                            responsabilidades={responsabilidades}
                            contact={contact}
                            S_N={S_N}
                        />
                    )}

                    {tab == "resoluciones" && (
                        <Resoluciones
                            auth={auth}
                            tipoDocumentos={tipoDocumentos}
                            tipoEmpresas={tipoEmpresas}
                            departamentos={departamentos}
                            responsabilidades={responsabilidades}
                            contact={contact}
                            estados={estados_resoluciones}
                        />
                    )}

                    {tab == "consecutivo" && (
                        <Consecutivo />
                    )}

                    {tab == "credenciales" && (
                        <Credenciales
                            auth={auth}
                            estados={estados}
                        />
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
};
