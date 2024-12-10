import React from "react";
import NavLink from "@/Components/NavLink";

export default ({ auth }) => {
    return (
        <>
            <h2 className="font-semibold text-2xl text-gray-800 leading-tight">
                {" "}
                Ooops....{" "}
            </h2>
            No encontramos una resolución de Autorización <b>Activa</b>.
            <br />
            Por favor registra una &nbsp;
            <NavLink
                className="!font-bold !text-md !bg-blue-300 rounded"
                href={"/gastos/configuracion"}
            >
                aquí
            </NavLink>
        </>
    );
};
