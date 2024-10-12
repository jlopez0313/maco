import InputError from "@/Components/Form/InputError";
import InputLabel from "@/Components/Form/InputLabel";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import TextInput from "@/Components/Form/TextInput";
import { useForm } from "@inertiajs/react";
import React, { useEffect } from "react";
import axios from "axios";
import Select from "@/Components/Form/Select";

export default ({ id, S_N, clientesId, auth, setIsOpen, onReload }) => {

    const { data, setData, processing, errors, reset } = useForm({
        updated_by: auth.user.id,
        nombre: '',
        celular: '',
        correo: '',
        principal: '',
        clientes_id: clientesId,
    });

    const submit = async (e) => {
        e.preventDefault();

        
        if ( id ) {
            await axios.put(`/api/v1/contactos/${id}`, data);
        } else {
            await axios.post(`/api/v1/contactos`, data);
        }

        onReload();
    };

    const onGetItem = async () => {

        const { data } = await axios.get(`/api/v1/contactos/${id}`);
        const item = { ...data.data }

        setData(
            {
                updated_by: auth.user.id,
                nombre: item.nombre,
                celular: item.celular,
                correo: item.correo,
                principal: item.principal,
                clientes_id: item.clientes?.id,
            }
        )
    }

    useEffect( () => {
        id && onGetItem()
    }, [])

    return (
        <div className="pb-12 pt-6">
            <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <form onSubmit={submit}>
                    <div className="grid grid-cols-2 gap-4">
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
                            <InputLabel htmlFor="celular" value="Celular" />

                            <TextInput
                               placeholder="Escriba aquí"
                                id="celular"
                                type="text"
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
                                type="email"
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

                        <div>
                            <InputLabel htmlFor="principal" value="Principal" />

                            <Select
                                id="principal"
                                name="principal"
                                className="mt-1 block w-full"
                                value={data.principal}
                                onChange={(e) =>
                                    setData(
                                        "principal",
                                        e.target.value
                                    )
                                }
                            >
                                {S_N.map((tipo, key) => {
                                    return (
                                        <option value={tipo.key} key={key}>
                                            {" "}
                                            {tipo.valor}{" "}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.principal}
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
