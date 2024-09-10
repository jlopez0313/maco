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
        responsabilidad_fiscal_id: "",
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
            responsabilidad_fiscal_id: item.responsabilidad?.id || "",
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
                        Información General
                    </h2>
                    <div className="grid grid-cols-2 gap-4 mt-6">
                        <div>
                            <InputLabel
                                htmlFor="tipo_id"
                                value="Tipo de Empresa"
                            />

                            <Select
                                id="tipo_id"
                                name="tipo_id"
                                className="mt-1 block w-full"
                                value={data.tipo_id}
                                onChange={(e) =>
                                    setData("tipo_id", e.target.value)
                                }
                            >
                                {tipos.map((tipo, key) => {
                                    return (
                                        <option value={tipo.id} key={key}>
                                            {" "}
                                            {tipo.tipo}{" "}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.tipo_id}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="responsabilidad_fiscal_id"
                                value="Responsabilidad Fiscal"
                            />

                            <Select
                                id="responsabilidad_fiscal_id"
                                name="responsabilidad_fiscal_id"
                                className="mt-1 block w-full"
                                value={data.responsabilidad_fiscal_id}
                                onChange={(e) =>
                                    setData(
                                        "responsabilidad_fiscal_id",
                                        e.target.value
                                    )
                                }
                            >
                                {responsabilidadesLst.map((tipo, key) => {
                                    return (
                                        <option value={tipo.id} key={key}>
                                            {" "}
                                            {tipo.descripcion}{" "}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.responsabilidad_fiscal_id}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="tipo_doc"
                                value="Tipo de Documento"
                            />

                            <Select
                                id="tipo_doc_id"
                                name="tipo_doc_id"
                                className="mt-1 block w-full"
                                value={data.tipo_doc_id}
                                onChange={(e) =>
                                    setData("tipo_doc_id", e.target.value)
                                }
                            >
                                {tipos_doc.map((tipo, key) => {
                                    return (
                                        <option value={tipo.id} key={key}>
                                            {" "}
                                            {tipo.tipo}{" "}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.tipo_doc_id}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="documento" value="Documento sin puntos ni dígitos de verificación" />
                            <TextInput
                                placeholder="Escriba aquí"
                                id="documento"
                                type="number"
                                name="documento"
                                value={data.documento}
                                className="mt-1 block w-full"
                                autoComplete="documento"
                                isFocused={true}
                                onChange={(e) =>
                                    setData("documento", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.documento}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="nombre" value="Nombre" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="nombre"
                                type="text"
                                name="nombre"
                                value={data.nombre}
                                className="mt-1 block w-full"
                                autoComplete="nombre"
                                onChange={(e) =>
                                    setData("nombre", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.nombre}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="comercio"
                                value="Nombre Comercial"
                            />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="comercio"
                                type="text"
                                name="comercio"
                                value={data.comercio}
                                className="mt-1 block w-full"
                                autoComplete="comercio"
                                onChange={(e) =>
                                    setData("comercio", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.comercio}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="matricula"
                                value="Matrícula Mercantíl"
                            />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="matricula"
                                type="number"
                                name="matricula"
                                value={data.matricula}
                                className="mt-1 block w-full"
                                autoComplete="matricula"
                                onChange={(e) =>
                                    setData("matricula", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.matricula}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="departamento"
                                value="Departamento"
                            />

                            <Select
                                id="departamento"
                                name="departamento"
                                className="mt-1 block w-full"
                                value={data.depto}
                                onChange={(e) => onGetCities(e.target.value)}
                            >
                                {deptos.map((depto, key) => {
                                    return (
                                        <option value={depto.id} key={key}>
                                            {" "}
                                            {depto.departamento}{" "}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.departamento}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="ciudad" value="Ciudad" />

                            <Select
                                id="ciudad"
                                name="ciudad"
                                className="mt-1 block w-full"
                                value={data.ciudad}
                                onChange={(e) =>
                                    setData("ciudad", e.target.value)
                                }
                            >
                                {ciudades.map((ciudad, key) => {
                                    return (
                                        <option value={ciudad.id} key={key}>
                                            {" "}
                                            {ciudad.ciudad}{" "}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.ciudad}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="direccion" value="Dirección" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="direccion"
                                type="text"
                                name="direccion"
                                value={data.direccion}
                                className="mt-1 block w-full"
                                autoComplete="direccion"
                                onChange={(e) =>
                                    setData("direccion", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.direccion}
                                className="mt-2"
                            />
                        </div>
                    </div>
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
