import Table from "@/Components/Table/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router } from "@inertiajs/react";

export default function Dashboard({ auth }) {
    const titles = ["Parámetro", "Descripción"];

    const list = [
        {
            id: "IMPR",
            parametro: "Parámetros de Impresión",
            descripcion: "Gestionar las Formas de Impresión",
            ruta: "parametros/impresion",
            roles_adm: ["SUDO", "ADMIN"],
        },
        {
            id: "USUA",
            parametro: "Usuarios",
            descripcion: "Gestionar los Usuarios de la plataforma",
            ruta: "parametros/usuarios",
            roles_adm: ["SUDO", "ADMIN"],
        },
        {
            id: "TICL",
            parametro: "Tipos de Personas",
            descripcion: "Gestionar los Tipos de Personas que se desea manejar",
            ruta: "parametros/tipos_clientes",
            roles_adm: ["SUDO", "ADMIN"],
        },
        {
            id: "TIDO",
            parametro: "Tipos de Documentos",
            descripcion:
                "Gestionar los Tipos de Documentos que se desea manejar",
            ruta: "parametros/tipos_documentos",
            roles_adm: ["SUDO", "ADMIN"],
        },
        {
            id: "REFI",
            parametro: "Responsabilidades Fiscales",
            descripcion:
                "Gestionar los tipos de Responsabilidades Fiscales que se desea manejar",
            ruta: "parametros/responsabilidades_fiscales",
            roles_adm: ["SUDO", "ADMIN"],
        },
        {
            id: "IMPU",
            parametro: "Impuestos",
            descripcion: "Gestionar los impuestos de la empresa",
            ruta: "parametros/impuestos",
            roles_adm: ["SUDO", "ADMIN"],
        },
        {
            id: "CONC",
            parametro: "Conceptos",
            descripcion: "Acción / Gasto a registrar en la sección de Compras",
            ruta: "parametros/conceptos",
            roles_adm: ["SUDO", "ADMIN"],
        },
        {
            id: "MEPA",
            parametro: "Medios de Pago",
            descripcion:
                "Gestionar los medios de pago que tienen las facturas que se manejan. ",
            ruta: "parametros/medios_pago",
            roles_adm: [],
        },
        {
            id: "FOPA",
            parametro: "Formas de Pago",
            descripcion:
                "Gestionar las formas de pago que tienen las facturas que se manejan. ",
            ruta: "parametros/formas_pago",
            roles_adm: [],
        },
        {
            id: "BANC",
            parametro: "Bancos",
            descripcion: "Gestionar los Bancos que se utilizan",
            ruta: "parametros/bancos",
            roles_adm: [],
        },
        {
            id: "UNME",
            parametro: "Unidades de Medida",
            descripcion:
                "Gestionar Unidades de Medida que tienen los productos que se manejan. ",
            ruta: "parametros/unidades_medida",
            roles_adm: [],
        },
        {
            id: "MEDI",
            parametro: "Medidas",
            descripcion:
                "Gestionar Tallas, Mililitros, entre otros, que tienen los productos que se manejan. ",
            ruta: "parametros/medidas",
            roles_adm: [],
        },
        {
            id: "COLO",
            parametro: "Colores",
            descripcion: "Gestionar los diferentes colores que se manejan",
            ruta: "parametros/colores",
            roles_adm: [],
        },
    ];

    const onNavigate = (id) => {
        const route = list.find((item) => item.id === id);
        router.get(route.ruta);
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Configuración
                </h2>
            }
        >
            <Head title="Configuración" />

            <div className="py-12">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table
                            user={auth.user}
                            data={list}
                            titles={titles}
                            actions={["chevron-right"]}
                            onEdit={onNavigate}
                            onRow={onNavigate}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
