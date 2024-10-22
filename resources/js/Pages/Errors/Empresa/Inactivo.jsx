import React, { Suspense, useEffect, useState } from "react";
// import Layout from '@/Components/Layout';
import Icon from "@/Components/Icon";
// import SearchFilter from '@/Shared/SearchFilter';

import GuestLayout from "@/Layouts/GuestLayout";
import { Head } from "@inertiajs/react";
import styles from "../Errors.module.css";

export default ({ auth, ...props }) => {
    return (
        <GuestLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Sitio Inactivo...
                </h2>
            }
        >
            <Head title="Ooops..." />

            <div className="py-12">
                <div className="max-w-6xl mx-auto sm:px-4 lg:px-4">
                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <div
                            className={`text-gray-900 ${styles["bg-robot"]}`}
                        >
                            <h2 className="font-semibold text-2xl text-gray-800 leading-tight mb-5">
                                {" "}
                                Ooops....{" "}
                            </h2>
                                Apreciado Cliente, <br /><br />
                                Tu sitio se encuentra inactivo por falta de pago. <br /><br />
                                
                                Por favor realiza tu pago y ponte en contacto con nostros. <br /><br />

                                Métodos de pago: <br />

                                <b> Bancolombia: 20 511 124 710 </b> <br />
                                <b> Nequi: 317 262 3919        </b> <br />
                                <b> NU: 35 391 278         </b>

                                <br />
                                <br />

                                ¡Gracias por confiar en nuestros servicios!
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
};
