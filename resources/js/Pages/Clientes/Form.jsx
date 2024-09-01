import InputError from "@/Components/Form/InputError";
import InputLabel from "@/Components/Form/InputLabel";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import TextInput from "@/Components/Form/TextInput";
import Select from "@/Components/Form/Select";
import { useForm } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import axios from "axios";
import { calcularDigitoVerificacion } from "@/Helpers/Numbers";

export const Form = ({
    id,
    auth,
    tipoDocumentos,
    tipoClientes,
    departamentos,
    responsabilidades,
    setIsOpen,
    onReload,
}) => {
    const [ciudades, setCiudades] = useState([]);

    const { data, setData, processing, errors, reset } = useForm({
        updated_by: auth.user.id,
        responsabilidad_fiscal_id: "",
        tipo_doc_id: "",
        documento: "",
        dv: "",
        nombre: "",
        comercio: "",
        tipo: "",
        depto: "",
        ciudad: "",
        direccion: "",
        celular: "",
        correo: "",
        matricula: "",
    });

    const { data: tipos } = tipoClientes;

    const { data: tipos_doc } = tipoDocumentos;

    const { data: responsabilidadesLst } = responsabilidades;

    const { data: deptos } = departamentos;

    const submit = async (e) => {
        e.preventDefault();

        if (id) {
            await axios.put(`/api/v1/clientes/${id}`, data);
        } else {
            await axios.post(`/api/v1/clientes`, data);
        }
        onReload();
    };

    const onGetItem = async () => {
        const { data } = await axios.get(`/api/v1/clientes/${id}`);
        const item = { ...data.data };

        await onGetCities(item.ciudad.departamento.id);

        setData({
            updated_by: auth.user.id,
            responsabilidad_fiscal_id: item.responsabilidad?.id || "",
            tipo_doc_id: item.tipo_doc?.id || "",
            documento: item.documento || "",
            dv: item.dv || "",
            nombre: item.nombre || "",
            comercio: item.comercio || "",
            tipo: item.tipo?.id || "",
            depto: item.ciudad?.departamento?.id || "",
            ciudad: item.ciudad?.id || "",
            direccion: item.direccion || "",
            celular: item.celular || "",
            matricula: item.matricula,
            correo: item.correo || "",
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

    useEffect(() => {
        id && onGetItem();
    }, []);

    useEffect(() => {
        data.documento && onGetDV(data.documento);
    }, [data.documento]);

    return (
        <div className="pb-12 pt-6">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form onSubmit={submit}>
                    <div className="grid grid-cols-2 gap-4">
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
                            <InputLabel htmlFor="documento" value="Documento" />
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
                                htmlFor="tipo"
                                value="Tipo de Cliente"
                            />

                            <Select
                                id="tipo"
                                name="tipo"
                                className="mt-1 block w-full"
                                value={data.tipo}
                                onChange={(e) =>
                                    setData("tipo", e.target.value)
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
                                message={errors.tipo}
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

                        <div>
                            <InputLabel htmlFor="celular" value="Celular" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="celular"
                                type="number"
                                name="celular"
                                value={data.celular}
                                className="mt-1 block w-full"
                                autoComplete="celular"
                                onChange={(e) =>
                                    setData("celular", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.celular}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="correo" value="Correo" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="correo"
                                name="correo"
                                value={data.correo}
                                className="mt-1 block w-full"
                                autoComplete="correo"
                                onChange={(e) =>
                                    setData("correo", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.correo}
                                className="mt-2"
                            />
                        </div>
                    </div>

                    <div className="flex items-center justify-end mt-4">
                        <PrimaryButton
                            className="ms-4 mx-4"
                            disabled={processing}
                        >
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
        </div>
    );
};
