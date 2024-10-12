import InputError from "@/Components/Form/InputError";
import InputLabel from "@/Components/Form/InputLabel";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import TextInput from "@/Components/Form/TextInput";
import { useForm } from "@inertiajs/react";
import React, { useEffect } from "react";
import axios from "axios";

export const Form = ({ id, setIsOpen, onReload }) => {
    const { data, setData, processing, errors, reset } = useForm({
        codigo: "",
        descripcion: "",
    });

    const submit = async (e) => {
        e.preventDefault();

        if (id) {
            await axios.put(`/api/v1/responsabilidades-fiscales/${id}`, data);
        } else {
            await axios.post(`/api/v1/responsabilidades-fiscales`, data);
        }

        onReload();
    };

    const onGetItem = async () => {
        const { data } = await axios.get(`/api/v1/responsabilidades-fiscales/${id}`);
        const item = { ...data.data };

        setData({
            codigo: item.codigo,
            descripcion: item.descripcion,
        });
    };

    useEffect(() => {
        id && onGetItem();
    }, []);

    return (
        <div className="pb-12 pt-6">
            <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <form onSubmit={submit}>
                    <div className="grid grid-cols-1 gap-4">
                        <div>
                            <InputLabel htmlFor="codigo" value="Código" />

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
                            <InputLabel htmlFor="descripcion" value="Descripcion" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="descripcion"
                                type="text"
                                name="descripcion"
                                value={data.descripcion}
                                className="mt-1 block w-full"
                                autoComplete="descripcion"
                                isFocused={true}
                                onChange={(e) =>
                                    setData("descripcion", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.descripcion}
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
