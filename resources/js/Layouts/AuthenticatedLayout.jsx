import { useState } from "react";
import ApplicationLogo from "@/Components/ApplicationLogo";
import Dropdown from "@/Components/Dropdown";
import NavLink from "@/Components/NavLink";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink";
import { Link } from "@inertiajs/react";

import "react-toastify/dist/ReactToastify.css";
import { ToastContainer } from "react-toastify";

export default function Authenticated({ user, header, children }) {

    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);

    return (
        <div className="min-h-screen flex flex-row">
            <ToastContainer />

            <nav className="bg-white border-b border-gray-100">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex flex-col">
                            <div className="shrink-0 flex items-center">
                                <Link href="/dashboard">
                                    <ApplicationLogo className="mt-3 block h-30 w-auto fill-current text-gray-800" />
                                </Link>
                            </div>

                            <div className="hidden space-x-8 sm:-my-px sm:mt-8 sm:flex no-print">
                                <NavLink
                                    href={"/dashboard"}
                                    active={route().current("dashboard")}
                                >
                                    Inicio
                                </NavLink>
                            </div>

                            <div className="hidden space-x-8 sm:-my-px sm:mt-8 sm:flex no-print">
                                <NavLink
                                    href={"/parametros"}
                                    active={route().current("parametros")}
                                >
                                    Configuración
                                </NavLink>
                            </div>

                            {
                                ['SUDO', 'ADMIN' ].includes(user.rol.slug) && 
                                    <div className="hidden space-x-8 sm:-my-px sm:mt-8 sm:flex no-print">
                                        <NavLink
                                            href={"/empresas"}
                                            active={route().current("empresas")}
                                        >
                                            Empresa
                                        </NavLink>
                                    </div>
                            }


                            <div className="hidden space-x-8 sm:-my-px sm:mt-8 sm:flex no-print">
                                <NavLink
                                    href={"/clientes"}
                                    active={route().current("clientes")}
                                >
                                    Clientes
                                </NavLink>
                            </div>

                            <div className="hidden space-x-8 sm:-my-px sm:mt-8 sm:flex no-print">
                                <NavLink
                                    href={"/inventario"}
                                    active={route().current("inventario")}
                                >
                                    Inventario
                                </NavLink>
                            </div>

                            <div className="hidden space-x-8 sm:-my-px sm:mt-8 sm:flex no-print">
                                <NavLink
                                    href={"/remisiones"}
                                    active={route().current("remisiones")}
                                >
                                    Ventas
                                </NavLink>
                            </div>

                            <div className="hidden space-x-8 sm:-my-px sm:mt-8 sm:flex no-print">
                                <NavLink
                                    href={"/gastos"}
                                    active={route().current("gastos")}
                                >
                                    Compras
                                </NavLink>
                            </div>

                            {/*

                            <div className="hidden space-x-8 sm:-my-px sm:mt-8 sm:flex">
                                <NavLink href={route('creditos')} active={route().current('creditos')}>
                                    Créditos
                                </NavLink>
                            </div>
                            
                            */}

                            <div className="hidden space-x-8 sm:-my-px sm:mt-8 sm:flex no-print">
                                <NavLink
                                    href={"/recaudos"}
                                    active={route().current("recaudos")}
                                >
                                    Recaudos
                                </NavLink>
                            </div>

                            <div className="hidden space-x-8 sm:-my-px sm:mt-8 sm:flex no-print">
                                <NavLink
                                    href={"/proveedores"}
                                    active={route().current("proveedores")}
                                >
                                    Proveedores
                                </NavLink>
                            </div>

                            <div className="hidden space-x-8 sm:-my-px sm:mt-8 sm:flex no-print">
                                <NavLink
                                    href={"/reportes"}
                                    active={route().current("reportes")}
                                >
                                    Reportes
                                </NavLink>
                            </div>

                            <div className="hidden space-x-8 sm:-my-px sm:mt-8 sm:flex no-print">
                                <NavLink href={"/logout"} method="post" as="button">
                                    Salir
                                </NavLink>
                            </div>
                        </div>

                        <div className="-me-2 flex items-center sm:hidden">
                            <button
                                onClick={() =>
                                    setShowingNavigationDropdown(
                                        (previousState) => !previousState
                                    )
                                }
                                className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg
                                    className="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        className={
                                            !showingNavigationDropdown
                                                ? "inline-flex"
                                                : "hidden"
                                        }
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        className={
                                            showingNavigationDropdown
                                                ? "inline-flex"
                                                : "hidden"
                                        }
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    className={
                        (showingNavigationDropdown ? "block" : "hidden") +
                        " sm:hidden"
                    }
                >
                    <div className="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            href={"/dashboard"}
                            active={route().current("dashboard")}
                        >
                            Inicio
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            href={"/parametros"}
                            active={route().current("parametros")}
                        >
                            Configuración
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            href={"/clientes"}
                            active={route().current("clientes")}
                        >
                            Clientes
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            href={"/inventario"}
                            active={route().current("inventario")}
                        >
                            Inventario
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            href={"/remisiones"}
                            active={route().current("remisiones")}
                        >
                            Ord. de Compra
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            href={"/gastos"}
                            active={route().current("gastos")}
                        >
                            Gastos
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            href={"/recaudos"}
                            active={route().current("recaudos")}
                        >
                            Recaudos
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            href={"/proveedores"}
                            active={route().current("proveedores")}
                        >
                            Proveedores
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            href={"/reportes"}
                            active={route().current("reportes")}
                        >
                            Reportes
                        </ResponsiveNavLink>

                        <ResponsiveNavLink
                            method="post"
                            href={"/logout"}
                            as="button"
                        >
                            Salir
                        </ResponsiveNavLink>
                    </div>

                    <div className="pt-4 pb-1 border-t border-gray-200">
                        <div className="px-4">
                            <div className="font-medium text-base text-gray-800">
                                {user.name}
                            </div>
                            <div className="font-medium text-sm text-gray-500">
                                {user.email}
                            </div>
                        </div>

                        <div className="mt-3 space-y-1">
                            {/*  <ResponsiveNavLink href={route('profile.edit')}>Profile</ResponsiveNavLink> */}
                        </div>
                    </div>
                </div>
            </nav>

            <div className="w-full bg-gray-100 ">
                {header && (
                    <header className="bg-white shadow">
                        <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {header}
                        </div>
                    </header>
                )}

                <main>{children}</main>
            </div>
        </div>
    );
}
