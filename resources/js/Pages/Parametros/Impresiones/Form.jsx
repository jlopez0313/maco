import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router, useForm } from "@inertiajs/react";

import InputError from "@/Components/Form/InputError";
import InputLabel from "@/Components/Form/InputLabel";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import TextInput from "@/Components/Form/TextInput";
import React, { useEffect } from "react";
import axios from "axios";
import Select from "@/Components/Form/Select";

export default ({ auth, id, formas }) => {
    const { data, setData, processing, errors, reset } = useForm({
        forma: "",
    });

    const submit = async (e) => {
        e.preventDefault();

        if (id) {
            await axios.put(`/api/v1/impresiones/${id}`, data);
        } else {
            await axios.post(`/api/v1/impresiones`, data);
        }

        onReload();
    };

    const onReload = () => {
        router.visit(window.location.pathname);
    };

    const onBack = () => {
        history.back();
    };
    

    const onGetItem = async () => {
        const { data } = await axios.get(`/api/v1/impresiones/${id}`);
        const item = { ...data.data };

        setData({
            forma: item.forma,
        });
    };

    useEffect(() => {
        id && onGetItem();
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Parámetros de Impresión
                </h2>
            }
        >
            <Head title="Parámetros de Impresión" />
            <div className="pb-12 pt-6">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div className="flex items-center justify-end mt-4 mb-4">
                        <SecondaryButton
                            className="ms-4"
                            onClick={() => onBack()}
                        >
                            Atras
                        </SecondaryButton>

                    </div>

                    <form onSubmit={submit}>
                        <div className="grid grid-cols-1 gap-4">
                            <div>
                                <InputLabel htmlFor="forma" value="Forma de Impresión" />

                                <Select
                                    placeholder="Escriba aquí"
                                    id="forma"
                                    name="forma"
                                    value={data.forma}
                                    className="mt-1 block w-full"
                                    autoComplete="forma"
                                    isFocused={true}
                                    onChange={(e) =>
                                        setData("forma", e.target.value)
                                    }
                                >
                                    {
                                        formas.map( (forma, idx) => {
                                            return <option value={forma.key} key={idx}> {forma.valor} </option>
                                        })
                                    }
                                </Select>

                                <InputError
                                    message={errors.forma}
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
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};
