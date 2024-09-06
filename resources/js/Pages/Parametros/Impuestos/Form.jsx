import InputError from "@/Components/Form/InputError";
import InputLabel from "@/Components/Form/InputLabel";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import TextInput from "@/Components/Form/TextInput";
import { useForm } from "@inertiajs/react";
import React, { useEffect } from "react";
import axios from "axios";
import Select from "@/Components/Form/Select";

export const Form = ({
    id,
    tipos_tarifas,
    tipos_impuestos,
    setIsOpen,
    onReload,
}) => {
    const { data, setData, processing, errors, reset } = useForm({
        codigo: "",
        concepto: "",
        tarifa: 0,
        tipo_tarifa: "",
        tipo_impuesto: "",
    });

    const submit = async (e) => {
        e.preventDefault();

        if (id) {
            await axios.put(`/api/v1/impuestos/${id}`, data);
        } else {
            await axios.post(`/api/v1/impuestos`, data);
        }

        onReload();
    };

    const onGetItem = async () => {
        const { data } = await axios.get(`/api/v1/impuestos/${id}`);
        const item = { ...data.data };

        setData({
            codigo: item.codigo,
            concepto: item.concepto,
            tarifa: item.tarifa,
            tipo_tarifa: item.tipo_tarifa,
            tipo_impuesto: item.tipo_impuesto,
        });
    };

    useEffect(() => {
        id && onGetItem();
    }, []);

    return (
        <div className="pb-12 pt-6">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form onSubmit={submit}>
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel htmlFor="codigo" value="Codigo" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="codigo"
                                type="text"
                                name="codigo"
                                value={data.codigo}
                                className="mt-1 block w-full"
                                autoComplete="codigo"
                                isFocused={true}
                                onChange={(e) =>
                                    setData("codigo", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.codigo}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="concepto" value="Concepto" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="concepto"
                                type="text"
                                name="concepto"
                                value={data.concepto}
                                className="mt-1 block w-full"
                                autoComplete="concepto"
                                isFocused={true}
                                onChange={(e) =>
                                    setData("concepto", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.concepto}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="tarifa" value="Tarifa" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="tarifa"
                                type="number"
                                name="tarifa"
                                value={data.tarifa}
                                className="mt-1 block w-full"
                                autoComplete="tarifa"
                                onChange={(e) =>
                                    setData("tarifa", e.target.value)
                                }
                            />
                            <InputError
                                message={errors.tarifa}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="tipo_tarifa"
                                value="Tipo de Tarifa"
                            />

                            <Select
                                placeholder="Escriba aquí"
                                id="tipo_tarifa"
                                name="tipo_tarifa"
                                className="mt-1 block w-full"
                                value={data.tipo_tarifa}
                                onChange={(e) =>
                                    setData("tipo_tarifa", e.target.value)
                                }
                            >
                                {tipos_tarifas.map((item, idx) => {
                                    return (
                                        <option key={idx} value={item.key}>
                                            {" "}
                                            {item.valor}{" "}
                                        </option>
                                    );
                                })}
                            </Select>
                            <InputError
                                message={errors.tipo_tarifa}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="tipo_impuesto"
                                value="Tipo de Impuesto"
                            />

                            <Select
                                placeholder="Escriba aquí"
                                id="tipo_impuesto"
                                name="tipo_impuesto"
                                className="mt-1 block w-full"
                                value={data.tipo_impuesto}
                                onChange={(e) =>
                                    setData("tipo_impuesto", e.target.value)
                                }
                            >
                                {tipos_impuestos.map((item, idx) => {
                                    return (
                                        <option key={idx} value={item.key}>
                                            {" "}
                                            {item.valor}{" "}
                                        </option>
                                    );
                                })}
                            </Select>
                            <InputError
                                message={errors.tipo_impuesto}
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
