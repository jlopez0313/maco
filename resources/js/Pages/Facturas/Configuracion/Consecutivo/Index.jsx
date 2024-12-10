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
import TextSpan from "@/Components/Form/TextSpan";

export default () => {

    const { data, setData, processing, errors, reset } = useForm({
        id: '',
        consecutivo: '',
        from: 'f'
    });

    const submit = async (e) => {
        e.preventDefault();

        try {
            if (data.id) {
                await axios.put(`/api/v1/consecutivos/${data.id}`, data);
            } else {
                await axios.post(`/api/v1/consecutivos`, data);
            }

            // notify('success', 'Datos de la Empresa registrados!')

            onReload();
        } catch (e) {
            console.log(e);
            notify("error", e.message);
        }
    };

    const onGetItem = async () => {
        const { data: {data: item } } = await axios.get(`/api/v1/consecutivos/first/f`);

        setData({
            id: item.id || "",
            consecutivo: item.consecutivo || "",
            from: item.from || "f",
        });
    };

    const onReload = () => {
        router.visit(window.location.pathname);
    };

    useEffect(() => {
        onGetItem();
    }, []);

    return (
        <div className="pb-12 pt-6">
            <form onSubmit={submit}>
                <div className="bg-white overflow-auto shadow-sm sm:rounded-lg p-6">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Consecutivo de Factura siguiente
                    </h2>
                    <div className="grid grid-cols-1 gap-4 mt-6">
                        <div>
                            <InputLabel
                                htmlFor="consecutivo"
                                value="Consecutivo Siguiente"
                            />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="consecutivo"
                                type="number"
                                name="consecutivo"
                                value={data.consecutivo}
                                className="mt-1 block w-full"
                                autoComplete="consecutivo"
                                isFocused={true}
                                onChange={(e) =>
                                    setData("consecutivo", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.consecutivo}
                                className="mt-2"
                            />
                        </div>
                    </div>
                </div>

                <div className="flex items-center justify-end mt-4">
                    <PrimaryButton className="ms-4 mx-4" disabled={processing}>
                        Guardar
                    </PrimaryButton>
                </div>
            </form>
        </div>
    );
};
