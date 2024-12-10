import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import InputError from "@/Components/Form/InputError";
import InputLabel from "@/Components/Form/InputLabel";
import TextInput from "@/Components/Form/TextInput";
import Modal from "@/Components/Modal";
import { useForm } from "@inertiajs/react";
import { useEffect, useState } from "react";
import { notify } from "@/Helpers/Notify";

export const AdminModal = ({ auth, title, show, setIsOpen, onConfirm }) => {

    const { data, setData, processing, errors, reset } = useForm({
        user_id: auth?.user?.id || 0,
        password: '',
    });

    const [action, setAction] = useState('');

    const submit = async (e) => {
        try {
            e.preventDefault();
            onConfirm( await axios.post('/api/v1/usuarios/get-admin', data) );
            reset();
        } catch( error ) {
            console.log( error.response.data.error )
            notify('error', error?.response?.data?.error || 'Internal Error. Try again.')
        }
    };

    const onReset = () => {
        reset();
        setIsOpen(false)
    }

    const onSetAction = () => {
        switch( title ) {
            case 'edit':
                setAction('Modificar')
            break;
            case 'trash':
                setAction('Eliminar')
            break;
        }
    }

    useEffect( () => {
        onSetAction()
    })

    return (
        <Modal show={show} closeable={true} title={`${action} registro`}>
            <div className="pb-12 pt-6">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <form>
                        <div className="grid grid-cols-1 gap-4">
                            <div>
                                <InputLabel htmlFor="tipo" value="Admin Password" />

                                <TextInput
placeholder="Escriba aquí"
                                    id="tipo"
                                    type="password"
                                    name="tipo"
                                    value={data.password}
                                    className="mt-1 block w-full"
                                    autoComplete="tipo"
                                    isFocused={true}
                                    onChange={(e) =>
                                        setData("password", e.target.value)
                                    }
                                />

                                <InputError
                                    message={errors.tipo}
                                    className="mt-2"
                                />
                            </div>
                        </div>
                        <div className="flex items-center justify-end mt-4">
                            <PrimaryButton
                                className="ms-4 mx-4"
                                disabled={processing}
                                onClick={submit}
                            >
                                
                                Continuar
                            </PrimaryButton>

                            <SecondaryButton
                                type="button"
                                onClick={() => onReset()}
                            >
                                
                                Cancelar
                            </SecondaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </Modal>
    )
}