import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import Logo from '../../img/logo.svg';

export default function Dashboard({ auth }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            rol={auth.rol}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Inicio</h2>}
        >
            <Head title="Inicio" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">Bienvenido!</div>
                    </div>

                    <img src={Logo} className='mx-auto mt-40' style={{opacity: '.2'}} />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
