import InputError from "@/Components/Form/InputError";
import InputLabel from "@/Components/Form/InputLabel";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import TextInput from "@/Components/Form/TextInput";
import { useForm } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import axios from "axios";
import Select from "@/Components/Form/Select";
import TextSpan from "@/Components/Form/TextSpan";

export default ({ id, empresasId, estados, auth, setIsOpen, onReload }) => {

    const [consecutivo, setConsecutivo ] = useState({});

    const { data, setData, processing, errors, reset } = useForm({
        updated_by: auth.user.id,
        empresas_id: empresasId,
        resolucion: '',
        prefijo: '',
        consecutivo_inicial: '',
        consecutivo_final: '',
        fecha_inicial: '',
        fecha_final: '',
        estado: '',
    });


    const submit = async (e) => {
        e.preventDefault();

        
        if ( id ) {
            await axios.put(`/api/v1/resoluciones/${id}`, data);
        } else {
            await axios.post(`/api/v1/resoluciones`, data);
        }

        onReload();
    };

    const onGetItem = async () => {

        const { data } = await axios.get(`/api/v1/resoluciones/${id}`);
        const item = { ...data.data }

        setData(
            {
                empresas_id: item.empresa?.id,
                resolucion: item.resolucion,
                prefijo: item.prefijo,
                consecutivo_inicial: item.consecutivo_inicial,
                consecutivo_final: item.consecutivo_final,
                fecha_inicial: item.fecha_inicial,
                fecha_final: item.fecha_final,
                estado: item.estado,
                updated_by: auth.user.id,
            }
        )
    }

    const onGetConsecutivo = async () => {
        const { data: consecutivo } = await axios.get(`/api/v1/resoluciones/consecutivo/${empresasId}`);
        const item = { ...consecutivo.data }

        setData(
            {
                ...data,
                consecutivo_inicial: item?.consecutivo_final + 1 || 1,
            }
        )
    }

    useEffect( () => {
        id && onGetItem()
        !id && empresasId && onGetConsecutivo();
        
    }, [id, empresasId])

    return (
        <div className="pb-12 pt-6">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form onSubmit={submit}>
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel htmlFor="resolucion" value="Resolución" />

                            <TextInput
                               placeholder="Escriba aquí"
                                id="nombre"
                                type="text"
                                name="resolucion"
                                value={data.resolucion}
                                className="mt-1 block w-full"
                                autoComplete="resolucion"
                                onChange={(e) =>
                                    setData("resolucion", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.resolucion}
                                className="mt-2"
                            />
                        </div>
                        
                        <div>
                            <InputLabel htmlFor="prefijo" value="Prefijo" />

                            <TextInput
                               placeholder="Escriba aquí"
                                id="prefijo"
                                type="text"
                                name="prefijo"
                                value={data.prefijo}
                                className="mt-1 block w-full"
                                autoComplete="prefijo"
                                onChange={(e) =>
                                    setData("prefijo", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.prefijo}
                                className="mt-2"
                            />
                        </div>

                        
                        <div>
                            <InputLabel htmlFor="consecutivo_inicial" value="Consecutivo Inicial" />

                            <TextSpan
                                value={data.consecutivo_inicial || 1}
                                className="mt-1 block w-full"
                            />

                            <InputError
                                message={errors.consecutivo_inicial}
                                className="mt-2"
                            />
                        </div>
                        
                        <div>
                            <InputLabel htmlFor="consecutivo_final" value="Consecutivo Final" />

                            <TextInput
                            placeholder="Escriba aquí"
                            min={data.consecutivo_inicial}
                                id="correo"
                                type="number"
                                name="consecutivo_final"
                                value={data.consecutivo_final}
                                className="mt-1 block w-full"
                                autoComplete="consecutivo_final"
                                onChange={(e) =>
                                    setData("consecutivo_final", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.consecutivo_final}
                                className="mt-2"
                            />
                        </div>
                        
                        <div>
                            <InputLabel htmlFor="fecha_inicial" value="Fecha Inicial" />

                            <TextInput
                               placeholder="Escriba aquí"
                                id="correo"
                                type="date"
                                name="fecha_inicial"
                                value={data.fecha_inicial}
                                className="mt-1 block w-full"
                                autoComplete="fecha_inicial"
                                onChange={(e) =>
                                    setData("fecha_inicial", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.fecha_inicial}
                                className="mt-2"
                            />
                        </div>
                        
                        <div>
                            <InputLabel htmlFor="fecha_final" value="Fecha Final" />

                            <TextInput
                               placeholder="Escriba aquí"
                                id="correo"
                                type="date"
                                name="fecha_final"
                                value={data.fecha_final}
                                className="mt-1 block w-full"
                                autoComplete="fecha_final"
                                onChange={(e) =>
                                    setData("fecha_final", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.fecha_final}
                                className="mt-2"
                            />
                        </div>
                        
                        <div>
                            <InputLabel htmlFor="estado" value="Estado" />

                            <Select
                                id="estado"
                                name="estado"
                                className="mt-1 block w-full"
                                value={data.estado}
                                onChange={(e) =>
                                    setData(
                                        "estado",
                                        e.target.value
                                    )
                                }
                            >
                                {estados.map((tipo, key) => {
                                    return (
                                        <option value={tipo.key} key={key}>
                                            {" "}
                                            {tipo.valor}{" "}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.estado}
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
