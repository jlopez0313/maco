import InputError from "@/Components/Form/InputError";
import InputLabel from "@/Components/Form/InputLabel";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import TextInput from "@/Components/Form/TextInput";
import Select from "@/Components/Form/Select";
import { useForm } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import axios from "axios";
import Table from "@/Components/Table/Table";

export const Form = ({
    auth,
    id,
    inventario,
    impuestosLst,
    retencionesLst,
    unidadesMedidaLst,
    colores,
    medidas,
    setIsOpen,
    onReload,
}) => {
    
    const titles = ["Concepto", "Tarifa", "Tipo de Tarifa", "Tipo de Impuesto"];

    const { data, setData, processing, errors, reset } = useForm({
        updated_by: auth.user.id,
        inventarios_id: inventario.id,
        referencia: "",
        colores_id: "",
        unidad_medida_id: "",
        medidas_id: "",
        cantidad: "",
        precio: "",
        impuestos: [],
    });

    const [tableList, setTableList] = useState([]);
    const [listaImptos, setListaImptos] = useState(impuestosLst);
    const [listaRetenciones, setListaRetenciones] = useState(retencionesLst);
    const [impuesto, setImpuesto] = useState('');
    const [retencion, setRetencion] = useState('');

    const submit = async (e) => {
        e.preventDefault();

        if (id) {
            await axios.put(`/api/v1/productos/${id}`, data);
        } else {
            await axios.post(`/api/v1/productos`, data);
        }
        onReload();
    };

    const onGetItem = async () => {
        const { data } = await axios.get(`/api/v1/productos/${id}`);
        const item = { ...data.data };

        setData({
            updated_by: auth.user.id,
            inventarios_id: inventario?.id || "",
            referencia: item.referencia || "",
            unidad_medida_id: item.unidad_medida_id || "",
            medidas_id: item.medida?.id || "",
            colores_id: item.color?.id || "",
            cantidad: item.cantidad,
            precio: item.precio,
            impuestos: item.impuestos,
        });
    };

    const onAddImpuesto = () => {
        data.impuestos.push({
            impuestos_id: impuesto,
            productos_id: id || null,
            impuesto: listaImptos.find( x => x.id == impuesto)
        });

        setData({
            ...data,
            impuestos: [...data.impuestos],
        });
    }

    const onAddRetencion = () => {
        data.impuestos.push({
            impuestos_id: retencion,
            productos_id: id || null,
            impuesto: listaRetenciones.find( x => x.id == retencion)
        });

        setData({
            ...data,
            impuestos: [...data.impuestos],
        });
    }

    const onListImpuestos = () => {
        const _tableList = data.impuestos.map((item) => {
            return {
                id: item.id,
                concepto: item.impuesto?.concepto || "",
                tarifa: item.impuesto?.tarifa,
                tipo_tarifa_label: item.impuesto?.tipo_tarifa_label || "",
                tipo_impuesto_label: item.impuesto?.tipo_impuesto_label || "",
            };
        });
        
        setTableList(_tableList);

        const tmp = data.impuestos.map( (item) => Number(item.impuestos_id) );
        const _imptos = impuestosLst.filter( _item => !tmp.includes( _item.id ) )
        const _retenciones = retencionesLst.filter( _item => !tmp.includes( _item.id ) )

        
        setListaImptos( _imptos )
        setListaRetenciones( _retenciones )
    }

    const onRemoveImpuesto = (_id) => {
        const currentImpuestos = data.impuestos.filter( x => x.id != _id);

        setData({
            ...data,
            impuestos: [...currentImpuestos],
        });
    }

    useEffect(() => {
        id && onGetItem();
    }, []);

    useEffect(() => {
        onListImpuestos();
    }, [data])

    return (
        <div className="pb-12 pt-6">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form onSubmit={submit}>
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel htmlFor="unidad_medida_id" value="Unidad de Medida" />

                            <Select
                                id="unidad_medida_id"
                                name="unidad_medida_id"
                                className="mt-1 block w-full"
                                value={data.unidad_medida_id}
                                onChange={(e) =>
                                    setData("unidad_medida_id", e.target.value)
                                }
                            >
                                {unidadesMedidaLst.map((tipo, key) => {
                                    return (
                                        <option value={tipo.id} key={key}>
                                            {tipo.descripcion}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.unidad_medida_id}
                                className="mt-2"
                            />
                        </div>
                        
                        <div>
                            <InputLabel htmlFor="medidas_id" value="Medida" />

                            <Select
                                id="medidas_id"
                                name="medidas_id"
                                className="mt-1 block w-full"
                                value={data.medidas_id}
                                onChange={(e) =>
                                    setData("medidas_id", e.target.value)
                                }
                            >
                                {medidas.map((tipo, key) => {
                                    return (
                                        <option value={tipo.id} key={key}>
                                            
                                            {tipo.medida}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.medidas_id}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="colores_id" value="Color" />

                            <Select
                                id="colores_id"
                                name="colores_id"
                                className="mt-1 block w-full"
                                value={data.colores_id}
                                onChange={(e) =>
                                    setData("colores_id", e.target.value)
                                }
                            >
                                {colores.map((tipo, key) => {
                                    return (
                                        <option value={tipo.id} key={key}>
                                            
                                            {tipo.color}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.colores_id}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="referencia"
                                value="Referencia"
                            />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="referencia"
                                type="text"
                                name="referencia"
                                value={data.referencia}
                                className="mt-1 block w-full"
                                autoComplete="referencia"
                                onChange={(e) =>
                                    setData("referencia", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.referencia}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="cantidad" value="Cantidad" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="cantidad"
                                type="number"
                                name="cantidad"
                                value={data.cantidad}
                                className="mt-1 block w-full"
                                autoComplete="cantidad"
                                onChange={(e) =>
                                    setData("cantidad", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.cantidad}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="precio"
                                value="Precio de Costo"
                            />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="precio"
                                type="number"
                                name="precio"
                                value={data.precio}
                                className="mt-1 block w-full"
                                autoComplete="precio"
                                onChange={(e) =>
                                    setData("precio", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.precio}
                                className="mt-2"
                            />
                        </div>
                    </div>

                    <div className="mt-5 bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table
                            caption="Impuestos Aplicados"
                            data={tableList}
                            links={[]}
                            onTrash={onRemoveImpuesto}
                            titles={titles}
                            actions={["trash"]}
                        />
                    </div>

                    <div className="mt-5 grid grid-cols-1 gap-4">
                        <div>
                            <InputLabel
                                htmlFor="medidas_id"
                                value="Agregar Impuesto"
                            />

                            <Select
                                id="impuestos_id"
                                name="impuestos_id"
                                className="mt-1 block w-full"
                                onChange={(e) =>
                                    setImpuesto(e.target.value)
                                }
                            >
                                {listaImptos.map((tipo, key) => {
                                    return (
                                        <option value={tipo.id} key={key}>
                                            {tipo.concepto} - {tipo.tarifa} - {tipo.tipo_tarifa_label}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.impuestos_id}
                                className="mt-2"
                            />
                        </div>
                    </div>

                    <div className="flex items-center justify-end mt-4">
                        <SecondaryButton
                            type="button"
                            onClick={onAddImpuesto}
                        >
                            Agregar
                        </SecondaryButton>
                    </div>

                    <div className="mt-2 grid grid-cols-1 gap-4">
                        <div>
                            <InputLabel
                                htmlFor="medidas_id"
                                value="Agregar Retención"
                            />

                            <Select
                                id="retenciones_id"
                                name="retenciones_id"
                                className="mt-1 block w-full"
                                onChange={(e) =>
                                    setRetencion(e.target.value)
                                }
                            >
                                {listaRetenciones.map((tipo, key) => {
                                    return (
                                        <option value={tipo.id} key={key}>
                                            {tipo.concepto} - {tipo.tarifa} - {tipo.tipo_tarifa_label}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.retenciones_id}
                                className="mt-2"
                            />
                        </div>
                    </div>

                    <div className="flex items-center justify-end mt-4">
                        <SecondaryButton
                            type="button"
                            onClick={onAddRetencion}
                        >
                            Agregar
                        </SecondaryButton>
                    </div>

                    <div className="mt-11 flex items-center justify-end mt-4">
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

                    <TextInput
                        placeholder="Escriba aquí"
                        id="inventarios_id"
                        type="hidden"
                        name="inventarios_id"
                        value={inventario.id}
                        className="mt-1 block w-full"
                        autoComplete="inventarios_id"
                        onChange={(e) =>
                            setData("inventarios_id", e.target.value)
                        }
                    />
                </form>
            </div>
        </div>
    );
};
