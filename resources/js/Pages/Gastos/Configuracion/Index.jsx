import React, { useEffect, useState } from "react";
// import Layout from '@/Components/Layout';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import Resoluciones from "./Resoluciones/Index";
import Consecutivo from "./Consecutivo/Index";

export default ({
    auth,
    tenant_id,
    tipoDocumentos,
    tipoEmpresas,
    departamentos,
    responsabilidades,
    estados_autorizaciones,
    estados,
    S_N,
    contact,
}) => {
    const [tab, setTab] = useState("resoluciones");

    useEffect(() => {

    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Configuración de Autorizaciones
                </h2>
            }
        >
            <Head title="Configuración de Autorizaciones" />

            <div className="pb-12 pt-6">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg p-6 mt-6">
                        <div className="flex justify-around">

                            <div
                                className={`cursor-pointer items-center font-bold ${ tab == 'resoluciones' ? 'underline' : ''}`}
                                onClick={() => setTab("resoluciones")}
                            >
                                Resoluciones de Autorizaciones
                            </div>

                            <div
                                className={`cursor-pointer items-center font-bold ${ tab == 'consecutivo' ? 'underline' : ''}`}
                                onClick={() => setTab("consecutivo")}
                            >
                                Consecutivo de Autorización
                            </div>

                        </div>
                    </div>

                    {tab == "resoluciones" && (
                        <Resoluciones
                            auth={auth}
                            tipoDocumentos={tipoDocumentos}
                            tipoEmpresas={tipoEmpresas}
                            departamentos={departamentos}
                            responsabilidades={responsabilidades}
                            contact={contact}
                            estados={estados_autorizaciones}
                        />
                    )}

                    {tab == "consecutivo" && (
                        <Consecutivo />
                    )}

                </div>
            </div>
        </AuthenticatedLayout>
    );
};
