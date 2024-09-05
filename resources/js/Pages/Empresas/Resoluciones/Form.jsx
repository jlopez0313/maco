import React, { useEffect, useState } from "react";
// import Layout from '@/Components/Layout';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import InputError from "@/Components/Form/InputError";
import InputLabel from "@/Components/Form/InputLabel";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import TextInput from "@/Components/Form/TextInput";
import Select from "@/Components/Form/Select";
import { Head, useForm, router } from "@inertiajs/react";
import axios from "axios";
import { calcularDigitoVerificacion } from "@/Helpers/Numbers";
import { notify } from "@/Helpers/Notify";

export default ({
    auth,
    tipoDocumentos,
    tipoEmpresas,
    departamentos,
    responsabilidades,
    contact,
}) => {
    const [ciudades, setCiudades] = useState([]);
    const [id, setId] = useState([]);

    const { data, setData, processing, errors, reset } = useForm({
        updated_by: auth.user.id,
        tipo_doc_id: "",
        documento: "",
        dv: "",
        nombre: "",
        comercio: "",
        matricula: "",
        tipo_id: "",
        depto: "",
        ciudad: "",
        direccion: "",
        prefijo: "",
    });

    const { data: tipos } = tipoEmpresas;

    const { data: tipos_doc } = tipoDocumentos;

    const { data: deptos } = departamentos;

    const { data: responsabilidadesLst } = responsabilidades;

    const submit = async (e) => {
        e.preventDefault();

        try {
            if (id) {
                await axios.put(`/api/v1/empresas/${id}`, data);
            } else {
                await axios.post(`/api/v1/empresas`, data);
            }

            // notify('success', 'Datos de la Empresa registrados!')

            onReload();
        } catch (e) {
            console.log(e);
            notify("error", e.message);
        }
    };

    const onGetItem = async () => {
        const { data: empresa } = contact;
        const item = { ...empresa };

        await onGetCities(item.ciudad?.departamento?.id);

        setId(item.id);

        setData({
            ...data,
            updated_by: auth.user.id,
            tipo_doc_id: item.tipo_doc?.id || "",
            documento: item.documento || "",
            dv: item.dv || "",
            nombre: item.nombre || "",
            comercio: item.comercio || "",
            matricula: item.matricula || "",
            tipo_id: item.tipo?.id || "",
            depto: item.ciudad?.departamento?.id || "",
            ciudad: item.ciudad?.id || "",
            direccion: item.direccion || "",
            prefijo: item.prefijo || "",
            // celular: item.celular || "",
            // correo: item.correo || "",
        });
    };

    const onGetCities = async (deptoID) => {
        if (deptoID) {
            const { data } = await axios.get(`/api/v1/ciudades/${deptoID}`);

            setData("depto", deptoID);
            setCiudades(data.data);
        } else {
            setCiudades([]);
        }
    };

    const onGetDV = (myNit) => {
        const dv = calcularDigitoVerificacion(String(myNit));

        if (dv) {
            setData("dv", dv);
        }
    };

    const onReload = () => {
        router.visit(window.location.pathname);
    };

    useEffect(() => {
        onGetItem();
    }, []);

    useEffect(() => {
        data.documento && onGetDV(data.documento);
    }, [data.documento]);

    return (
        <div className="pb-12 pt-6">
            <form onSubmit={submit}>
                <div className="bg-white overflow-auto shadow-sm sm:rounded-lg p-6">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Resoluciones de Facturación
                    </h2>
                    <div className="grid grid-cols-2 gap-4 mt-6"></div>
                </div>

                <div className="flex items-center justify-end mt-4">
                    <PrimaryButton className="ms-4 mx-4" disabled={processing}>
                        Guardar
                    </PrimaryButton>

                    <SecondaryButton
                        type="button"
                        onClick={() => setIsOpen(false)}
                    >
                        Cancelar
                    </SecondaryButton>
                </div>
            </form>
        </div>
    );
};
