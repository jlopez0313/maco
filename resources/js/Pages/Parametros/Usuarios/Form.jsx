import InputError from "@/Components/Form/InputError";
import InputLabel from "@/Components/Form/InputLabel";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import TextInput from "@/Components/Form/TextInput";
import { useForm } from "@inertiajs/react";
import React, { useEffect } from "react";
import axios from "axios";
import Select from "@/Components/Form/Select";

export const Form = ({ id, roles, setIsOpen, onReload }) => {

    const { data, setData, processing, errors, reset } = useForm({
        email: '',
        name: '',
        password: '',
        roles_id: '',
    });

    const { data: listaRoles } = roles;

    const submit = async (e) => {
        e.preventDefault();

        
        if ( id ) {
            await axios.put(`/api/v1/usuarios/${id}`, data);
        } else {
            await axios.post(`/api/v1/usuarios`, data);
        }

        onReload();
    };

    const onGetItem = async () => {

        const { data } = await axios.get(`/api/v1/usuarios/${id}`);
        const item = { ...data.data }

        setData(
            {                
                email: item.email,
                name: item.name,
                password: '',
                roles_id: item.rol.id,
            }
        )
    }

    useEffect( () => {
        id && onGetItem()
    }, [])

    return (
        <div className="pb-12 pt-6">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form onSubmit={submit}>
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel htmlFor="email" value="Email" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="mt-1 block w-full"
                                autoComplete="email"
                                isFocused={true}
                                readOnly={id}
                                onChange={(e) =>
                                    setData("email", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.email}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <InputLabel htmlFor="name" value="Nombre" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="name"
                                type="text"
                                name="name"
                                value={data.name}
                                className="mt-1 block w-full"
                                autoComplete="name"
                                isFocused={true}
                                onChange={(e) =>
                                    setData("name", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.name}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <InputLabel htmlFor="roles_id" value="Rol" />

                            <Select
                                id="roles_id"
                                name="roles_id"
                                className="mt-1 block w-full"
                                value={data.roles_id}
                                onChange={(e) =>
                                    setData("roles_id", e.target.value)
                                }
                            >
                                {listaRoles.map((tipo, key) => {
                                    return (
                                        <option value={tipo.id} key={key}>
                                            
                                            {tipo.rol}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.roles_id}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <InputLabel htmlFor="password" value="Contraseña" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="password"
                                type="password"
                                name="password"
                                value={data.password}
                                className="mt-1 block w-full"
                                autoComplete="password"
                                isFocused={true}
                                onChange={(e) =>
                                    setData("password", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.password}
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
