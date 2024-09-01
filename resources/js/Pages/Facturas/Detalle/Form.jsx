import InputError from "@/Components/Form/InputError";
import InputLabel from "@/Components/Form/InputLabel";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import TextInput from "@/Components/Form/TextInput";
import Select from "@/Components/Form/Select";
import { useForm } from "@inertiajs/react";
import React, { useEffect, useState } from "react";
import axios from "axios";
import Icon from "@/Components/Icon";

export const Form = ({ id, auth, factura, setIsOpen, onReload }) => {

    const { data, setData, processing, errors, reset } = useForm({
        facturas_id: factura.id, 
        referencia: '',
        productos_id: '',
        cantidad: '',
        precio_venta: '',
    });

    const [producto, setProducto] = useState({});

    const submit = async (e) => {
        e.preventDefault();

        if ( id ) {
            await axios.put(`/api/v1/detalles/${id}`, data);
        } else {
            await axios.post(`/api/v1/detalles`, data);
        }
        onReload();
    };

    const onGetItem = async () => {

        const { data: info } = await axios.get(`/api/v1/detalles/${id}`);
        const item = { ...info.data }

        await setData(
            {
                facturas_id: factura.id, 
                referencia: item.producto?.referencia,
                productos_id: item.producto?.id || '',
                cantidad: item.cantidad,
                precio_venta: item.precio_venta,
            }
        )

        console.log( 'data1', data, item );

        onSearch( item.producto?.referencia, false )
    }

    const onSearch = async ( ref, set = true ) => {
        if ( ref )  {
            const { data: producto } = await axios.get(`/api/v1/productos/referencia/${ref}`);
            const item = { ...producto.data }

            if ( item )  {

                const vendidos = factura.detalles.filter( prod => prod.producto?.id === item.id)

                const suma = vendidos.reduce( (suma, prod) => {
                    return suma  + prod.cantidad
                }, 0)

                setProducto(
                    {                
                        id: item.id || '', 
                        articulo: item.inventario?.articulo || '', 
                        origen: item.inventario?.origenLabel || '', 
                        cantidad: (item.cantidad - suma) || 0, 
                        medida: item.medida?.medida || '', 
                        color: item.color?.color || '', 
                    }
                )

                set && setData(
                    {                
                        ...data,
                        productos_id: item.id || '',
                    }
                )
            } else {
                reset()
            }
        } else {
            reset()
        }
    }

    const onCheckCantidad = (e) => {
        if (e.target.value > producto.cantidad)  {
            alert('cantidad no disponible')
        } else {
            setData("cantidad", e.target.value);
        }

    }

    useEffect( () => {
        id && onGetItem();
    }, [])

    return (
        <div className="pb-12 pt-6">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form onSubmit={submit}>
                    <div className="grid grid-cols-2 gap-4">
                    </div>
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel htmlFor="referencia" value="Referencia" />

                            <div className="grid grid-cols-12 gap-4">
                                <TextInput
                                    placeholder="Escriba aquí"
                                    id="referencia"
                                    type="text"
                                    name="referencia"
                                    value={data.referencia}
                                    className="mt-1 block w-full col-start-1 col-span-10"
                                    autoComplete="referencia"
                                    onChange={(e) =>
                                        setData("referencia", e.target.value)
                                    }
                                    onBlur={(e) => onSearch(e.target.value)}
                                />
                                
                                <Icon
                                    name="search"
                                    className="self-center col-start-11 col-span-2 block w-6 h-6 "
                                />
                            </div>

                            <InputError
                                message={errors.referencia}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="producto" value="Producto" />

                            <TextInput
                                id="producto"
                                type="text"
                                name="producto"
                                value={producto.articulo || ''}
                                className="mt-1 block w-full"
                                autoComplete="producto"
                                required
                                readOnly
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="color" value="Color" />

                            <TextInput
                                id="color"
                                type="text"
                                name="color"
                                value={producto.color || ''}
                                className="mt-1 block w-full"
                                autoComplete="color"
                                required
                                readOnly
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="medida" value="Medida" />

                            <TextInput
                                id="medida"
                                type="text"
                                name="medida"
                                value={producto.medida || ''}
                                className="mt-1 block w-full"
                                autoComplete="medida"
                                required
                                readOnly
                            />
                        </div>

                        <div className="mb-10">
                            <InputLabel htmlFor="origen" value="Origen" />

                            <TextInput
                                id="origen"
                                type="text"
                                name="origen"
                                value={producto.origen || ''}
                                className="mt-1 block w-full"
                                autoComplete="origen"
                                required
                                readOnly
                            />
                        </div>
                        
                        <div>
                            <InputLabel htmlFor="cantidad" value="Cantidad Disponible" />

                            <TextInput
                                id="cantidad"
                                type="number"
                                name="cantidad"
                                value={producto.cantidad || ''}
                                className="mt-1 block w-full"
                                autoComplete="cantidad"
                                required
                                readOnly
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="cantidad" value="Cantidad a Vender" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="cantidad"
                                type="number"
                                name="cantidad"
                                value={data.cantidad}
                                className="mt-1 block w-full"
                                autoComplete="cantidad"
                                required
                                onChange={(e) =>
                                    onCheckCantidad( e )
                                }
                            />

                            <InputError
                                message={errors.cantidad}
                                className="mt-2"
                            />
                        </div>
                        
                        <div>
                            <InputLabel htmlFor="precio_venta" value="Precio de Venta" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="precio_venta"
                                type="number"
                                name="precio_venta"
                                value={data.precio_venta}
                                className="mt-1 block w-full"
                                autoComplete="precio_venta"
                                required
                                onChange={(e) =>
                                    setData("precio_venta", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.precio_venta}
                                className="mt-2"
                            />
                        </div>
                        
                    </div>

                    <div className="flex items-center justify-end mt-4">
                        <PrimaryButton
                            className="ms-4 mx-4"
                            disabled={processing || !producto.id}
                        >
                            
                            Registrar
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
                        id="facturas_id"
                        type="hidden"
                        name="facturas_id"
                        value={factura.id}
                        className="mt-1 block w-full"
                        autoComplete="facturas_id"
                        onChange={(e) =>
                            setData("facturas_id", e.target.value)
                        }
                    />
                </form>
            </div>
        </div>
    );
};
