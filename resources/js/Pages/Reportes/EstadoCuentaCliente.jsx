import PrimaryButton from '@/Components/Buttons/PrimaryButton';
import InputError from '@/Components/Form/InputError';
import InputLabel from '@/Components/Form/InputLabel';
import Select from '@/Components/Form/Select';
import TextInput from '@/Components/Form/TextInput';
import Table from '@/Components/Table/Table';
import { toCurrency } from '@/Helpers/Numbers';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';
import { useForm } from "@inertiajs/react";
import { useState } from 'react';

export default function Reportes({ auth, clientes }) {

    const { data, setData, processing, errors, reset } = useForm({
        fecha_inicial: '',
        fecha_final: '',
        clientes_id: ''
    });

    const {
        data: listaClientes,
    } = clientes;

    const titles = [
        "Fecha",
        "Cliente",
        'Valor Total',
        'Saldo',
    ];

    const [list, setList] = useState([]);


    
    const onSearch = async() => {
        const {data: {data: lista}} = await axios.post(`/api/v1/reportes/estado_cuenta_cliente/`, data);
        
        const valor = lista.map( item => {
            return item.detalles.reduce( (sum, det) => sum + ( det.precio_venta * det.cantidad ), 0 ) || 0 
        })
        
        const cobros = lista.map( item => {
            return item.recaudos.reduce( (sum, det) => sum + ( det.valor ), 0 ) || 0 
        })

        const _list = lista.map( (item, idx) => {
            return {
                'fecha': item.created_at,
                'cliente': item.cliente?.nombre,
                'valor': toCurrency( valor[idx] || 0 ),
                'saldo': toCurrency( (valor[idx] || 0) - (cobros[idx] || 0) ),
            }
        })

        setList( _list );
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Reporte de Estado de Cuentas por Cliente
                </h2>
            }
        >
            <Head title="Reporte de Estado de Cuentas por Cliente" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between mt-4 mb-6">
                        
                        <div className='w-full m-2'>
                            <InputLabel htmlFor="nombre" value="Fecha Inicial" />
                            <TextInput
                                placeholder="Fecha Inicial..."
                                id="nombre"
                                type="date"
                                name="nombre"
                                className="mt-1 block w-full me-4"
                                autoComplete="nombre"
                                value={data.fecha_inicial}
                                onChange={ (e) => 
                                    setData("fecha_inicial", e.target.value)
                                }
                            />
                        </div>

                        <div className='w-full m-2'>
                            <InputLabel htmlFor="nombre" value="Fecha Final" />
                            <TextInput
                                placeholder="Fecha Final..."
                                id="nombre"
                                type="date"
                                name="nombre"
                                min={data.fecha_inicial}
                                className="mt-1 block w-full me-4"
                                autoComplete="nombre"
                                value={data.fecha_final}
                                onChange={ (e) => 
                                    setData("fecha_final", e.target.value)
                                }
                            />
                        </div>

                        <div className='w-full m-2'>
                            <InputLabel
                                htmlFor="clientes_id"
                                value="Cliente"
                            />

                            <Select
                                id="clientes_id"
                                name="clientes_id"
                                className="mt-1 block w-full"
                                value={data.clientes_id}
                                onChange={(e) =>
                                    setData("clientes_id", e.target.value)
                                }
                            >
                                {
                                    listaClientes.map( (tipo, key) => {
                                        return <option value={ tipo.id } key={key}> { tipo.nombre} </option>
                                    })
                                }
                            </Select>

                            <InputError
                                message={errors.clientes_id}
                                className="mt-2"
                            />
                        </div>

                            <PrimaryButton
                                className="ms-4"
                                onClick={() => onSearch()}
                            >
                                Buscar
                            </PrimaryButton>
                    </div>

                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <Table
                            data={list}
                            links={[]}
                            onEdit={() => {}}
                            onTrash={() => {}}
                            titles={titles}
                            actions={[]}
                        />
                    </div>

                </div>
            </div>

        </AuthenticatedLayout>
    );
}
