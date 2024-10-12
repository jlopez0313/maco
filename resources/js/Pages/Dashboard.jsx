import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import Logo from "../../img/logo.svg";
import { useEffect, useState } from "react";

export default function Dashboard({ auth, created_at }) {

    const [message, setMessage] = useState(false);
    const [limitDate, setLimitDate] = useState('');

    const calculateFechaPago = () => {
        const timestamp = Date.parse(created_at);
        const limit = new Date(timestamp);
        
        const now = new Date();
        
        if (limit.getDate() - now.getDate() <= 7) {
            setMessage(true);
            setLimitDate( `${limit.getDate()}/${String(now.getMonth() + 1).padStart(2, '0')}/${now.getFullYear()}` )
        }
    };

    useEffect(() => {
        calculateFechaPago();
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            rol={auth.rol}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Inicio
                </h2>
            }
        >
            <Head title="Inicio" />

            <div className="py-12">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">Bienvenido!</div>
                    </div>
                    {message && (
                        <div className="bg-amber-50 overflow-auto shadow-sm sm:rounded-lg mt-5">
                            <div className="p-6 text-gray-900">
                                Apreciado Cliente, <br />
                                Le recordamos que su mensualidad está próxima a vencer, por favor
                                realizar su pago para evitar suspensión en el servicio. <br />
                                Por favor omita este mensaje si ya realizó su respectivo pago.<br /> <br />

                                Fecha límite de pago: <b> { limitDate } </b> <br /> <br />
                                Métodos de pago: <b> Bancolombia - Nequi - NU </b> <br /><br />

                                ¡Gracias por confiar en nuestros servicios!
                            </div>
                        </div>
                    )}

                    <img
                        src={Logo}
                        className="mx-auto mt-40"
                        style={{ opacity: ".2" }}
                    />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
