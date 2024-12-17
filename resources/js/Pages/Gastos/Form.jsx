import InputError from "@/Components/Form/InputError";
import InputLabel from "@/Components/Form/InputLabel";
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import TextInput from "@/Components/Form/TextInput";
import Select from "@/Components/Form/Select";
import { useForm } from "@inertiajs/react";
import React, { Suspense, useEffect, useState } from "react";
import axios from "axios";
import Icon from "@/Components/Icon";
import ContactosEmpty from "@/Pages/Errors/Proveedores/Contactos/Empty";
import { ReactSearchAutocomplete } from "react-search-autocomplete";

export const Form = ({
    id,
    auth,
    payments,
    proveedores,
    medios_pago,
    setIsOpen,
    onEdit,
}) => {
    const [ciudades, setCiudades] = useState([]);
    const [listaProveedores, setProveedores] = useState([]);

    const [LazyComponent, setLazyComponent] = useState(null);

    const { data: formasPago } = payments;
    const { data: proveedoresLst} = proveedores;

    const { data: mediosPago } = medios_pago;

    const { data, setData, processing, errors, reset } = useForm({
        updated_by: auth.user.id,
        proveedores_id: "",
        documento: "",
        nombre: "",
        departamento: "",
        ciudad: "",
        direccion: "",
        celular: "",
        correo: "",
        forma_pago_id: "",
        medio_pago_id: "",
    });

    const submit = async (e) => {
        e.preventDefault();

        let resp = {};

        if (id) {
            await axios.put(`/api/v1/gastos/${id}`, data);
        } else {
            resp = await axios.post(`/api/v1/gastos`, data);
        }

        onEdit(id || resp.data?.data?.id);
    };

    const onGetItem = async () => {
        
    };

    const onCheckDoc = (doc) => {
        if (!doc) {
            reset();
        } else {
            setData("documento", doc);
        }
    };

    const onSearchProveedor = async () => {
        if (data.documento) {
            setLazyComponent(null);

            const proveedor = proveedoresLst.find( x => x.documento == data.documento);

            if (proveedor) {
                await onGetCities(proveedor.ciudad?.departamento?.id);

                setData({
                    ...data,
                    proveedores_id: proveedor.id || "",
                    nombre: proveedor.nombre || "",
                    departamento: proveedor?.ciudad?.departamento?.id || "",
                    ciudad: proveedor?.ciudad?.id || "",
                    direccion: proveedor.direccion || "",
                    celular: proveedor.celular || "",
                    correo: proveedor.correo || "",
                    forma_pago_id: proveedor?.forma_pago?.id || 1,
                    medio_pago_id: proveedor?.medio_pago?.id || 9,
                });

                if (!proveedor.contacto) {
                    setLazyComponent("Proveedores/Empty");
                }
            } else {
                setLazyComponent("");
                reset();
            }
        } else {
            setLazyComponent("");
            reset();
        }
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

    const loadErrorPage = (error, props = {}) => {
        switch (error) {
            case "Contactos/Empty":
                return <ContactosEmpty {...props} />;
            default:
                return <></>;
        }
    };

    const handleOnSearch = (string, results) => {
        // onSearch will have as the first callback parameter
        // the string searched and for the second the results.
        console.log(string, results);
        
        if(!string || !results.length) {
            reset()
        }
    };

    const handleOnHover = (result) => {
        // the item hovered
        // console.log(result);
    };

    const handleOnSelect = (item) => {
        // the item selected
        onCheckDoc(item.name);
    };

    const handleOnFocus = () => {
        // console.log("Focused");
    };

    const formatResult = (item) => {
        return (
            <>
                <span style={{ display: "block", textAlign: "left" }}>
                    {item.name}
                </span>
            </>
        );
    };

    useEffect(() => {
        id && onGetItem();
    }, []);

    useEffect(() => {
        setProveedores( proveedoresLst.map( x => { return { id: x.id, name: x.documento.toString()} } ) )
    }, [proveedoresLst]);

    useEffect(() => {
        onSearchProveedor()
    }, [data.documento])

    
    return (
        <div className="pb-12 pt-6">
            <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <form onSubmit={submit}>
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel htmlFor="documento" value="Documento" />

                            <div className="grid grid-cols-12 gap-4">
                                <div
                                    style={{ width: 290, marginTop: "0.25rem" }}
                                >
                                    <ReactSearchAutocomplete
                                        placeholder="Escriba aquí"
                                        showNoResultsText="Sin registros"
                                        styling={{
                                            height: "42px",
                                            border: "1px solid rgb(209, 213, 219)",
                                            borderRadius: "0.375rem",
                                            //   backgroundColor: "white",
                                            boxShadow: "0px",
                                            //   hoverBackgroundColor: "#eee",
                                            color: "#000",
                                            fontSize: "15px",
                                            fontFamily: "Figtree",
                                            //   iconColor: "grey",
                                            //   lineColor: "rgb(232, 234, 237)",
                                            //   placeholderColor: "grey",
                                            clearIconMargin: "3px 10px 0 0",
                                            searchIconMargin: "0 0 0 10px",
                                            // };
                                        }}
                                        items={listaProveedores}
                                        fuseOptions={{minMatchCharLength: 1}}
                                        onSearch={handleOnSearch}
                                        onHover={handleOnHover}
                                        onSelect={handleOnSelect}
                                        onFocus={handleOnFocus}
                                        autoFocus
                                        formatResult={formatResult}
                                    />
                                </div>
                                {/* 
                                <TextInput
                                    placeholder="Escriba aquí"
                                    id="documento"
                                    type="text"
                                    name="documento"
                                    value={data.documento}
                                    className="mt-1 block w-full col-start-1 col-span-10"
                                    autoComplete="documento"
                                    onChange={(e) => onCheckDoc(e.target.value)}
                                    onBlur={onSearchCliente}
                                />

                                <Icon
                                    name="search"
                                    className="cursor-pointer self-center col-start-11 col-span-2 block w-6 h-6 "
                                />
                                */}
                            </div>

                            <InputError
                                message={errors.documento}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel htmlFor="nombre" value="Nombre" />

                            <TextInput
                                id="nombre"
                                type="text"
                                name="nombre"
                                value={data.nombre}
                                className="mt-1 block w-full"
                                autoComplete="nombre"
                                readOnly
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
                            <InputLabel htmlFor="correo" value="Correo" />

                            <TextInput
                                placeholder="Escriba aquí"
                                id="correo"
                                type="text"
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

                        {/*
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
                                {
                                    ciudades.map( (tipo, key) => {
                                        return <option value={ tipo.id } key={key}> { tipo.ciudad } </option>
                                    })
                                }
                            </Select>

                            <InputError
                                message={errors.ciudad}
                                className="mt-2"
                            />
                        </div>
                        
                        <div>
                            <InputLabel htmlFor="articulo" value="Dirección" />

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
                            <InputLabel htmlFor="tipo_id" value="Tipo" />

                            <Select
                                id="tipo"
                                name="tipo"
                                className="mt-1 block w-full"
                                value={data.tipo}
                                onChange={(e) =>
                                    setData("tipo", e.target.value)
                                }
                            >
                                {
                                    tipos.map( (tipo, key) => {
                                        return <option value={ tipo.id } key={key}> { tipo.tipo} </option>
                                    })
                                }
                            </Select>

                            <InputError
                                message={errors.tipo_id}
                                className="mt-2"
                            />
                        </div>
                        */}

                        <div>
                            <InputLabel
                                htmlFor="forma_pago_id"
                                value="Forma de Pago"
                            />

                            <Select
                                id="forma_pago_id"
                                name="forma_pago_id"
                                className="mt-1 block w-full"
                                value={data.forma_pago_id}
                                onChange={(e) =>
                                    setData("forma_pago_id", e.target.value)
                                }
                            >
                                {formasPago.map((tipo, key) => {
                                    return (
                                        <option value={tipo.id} key={key}>
                                            {" "}
                                            {tipo.descripcion}{" "}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.forma_pago_id}
                                className="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                htmlFor="medio_pago_id"
                                value="Medio de Pago"
                            />

                            <Select
                                id="medio_pago_id"
                                name="medio_pago_id"
                                className="mt-1 block w-full"
                                value={data.medio_pago_id}
                                onChange={(e) =>
                                    setData("medio_pago_id", e.target.value)
                                }
                            >
                                {mediosPago.map((tipo, key) => {
                                    return (
                                        <option value={tipo.id} key={key}>
                                            {" "}
                                            {tipo.descripcion}{" "}
                                        </option>
                                    );
                                })}
                            </Select>

                            <InputError
                                message={errors.medio_pago_id}
                                className="mt-2"
                            />
                        </div>
                    </div>

                    <div className="my-4 bg-error">
                        {LazyComponent && loadErrorPage("Contactos/Empty", {auth, id: data.proveedores_id})}
                    </div>

                    <div className="flex items-center justify-end mt-4">
                        <PrimaryButton
                            className="ms-4 mx-4"
                            disabled={processing || LazyComponent}
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
                        id="proveedores_id"
                        type="hidden"
                        name="proveedores_id"
                        value={data.proveedores_id}
                        className="mt-1 block w-full"
                        autoComplete="proveedores_id"
                        onChange={(e) => setData("proveedores_id", e.target.value)}
                    />
                </form>
            </div>
        </div>
    );
};
