import { useRef, useState } from 'react';
import DangerButton from "@/Components/Buttons/DangerButton";
import InputError from '@/Components/Form/InputError';
import InputLabel from '@/Components/Form/InputLabel';
import Modal from '@/Components/Modal';
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import TextInput from '@/Components/Form/TextInput';
import { useForm } from '@inertiajs/react';

export default function DeleteUserForm({ className = '' }) {
    const [confirmingUserDeletion, setConfirmingUserDeletion] = useState(false);
    const passwordInput = useRef();

    const {
        data,
        setData,
        delete: destroy,
        processing,
        reset,
        errors,
    } = useForm({
        password: '',
    });

    const confirmUserDeletion = () => {
        setConfirmingUserDeletion(true);
    };

    const deleteUser = (e) => {
        e.preventDefault();

        destroy(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput.current.focus(),
            onFinish: () => reset(),
        });
    };

    const closeModal = () => {
        setConfirmingUserDeletion(false);

        reset();
    };

    return (
        <section className={`space-y-6 ${className}`}>
            <header>
                <h2 className="text-lg font-medium text-gray-900">Eliminar Cuenta</h2>

                <p className="mt-1 text-sm text-gray-600">
                    Una vez tu cuenta ha sido eliminada, toda tu información relacionada será eliminada. 
                    Asegurate de guardar cualquier información que desees mantener antes de eliminar tu cuenta.
                </p>
            </header>

            <DangerButton onClick={confirmUserDeletion}>Eliminar Cuenta</DangerButton>

            <Modal show={confirmingUserDeletion} onClose={closeModal}>
                <form onSubmit={deleteUser} className="p-6">
                    <h2 className="text-lg font-medium text-gray-900">
                        Estas seguro de que deseas eliminar tu cuenta?
                    </h2>

                    <p className="mt-1 text-sm text-gray-600">
                        Una vez tu cuenta ha sido eliminada, toda tu información relacionada será eliminada. Por favor
                        ingresa tu contraseña actual para eliminar tu cuenta.
                    </p>

                    <div className="mt-6">
                        <InputLabel htmlFor="password" value="Contraseña" className="sr-only" />

                        <TextInput
                               placeholder="Escriba aquí"
                            id="password"
                            type="password"
                            name="password"
                            ref={passwordInput}
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            className="mt-1 block w-3/4"
                            isFocused
                            placeholder="Password"
                        />

                        <InputError message={errors.password} className="mt-2" />
                    </div>

                    <div className="mt-6 flex justify-end">
                        <SecondaryButton onClick={closeModal}>Cancelar</SecondaryButton>

                        <DangerButton className="ms-3" disabled={processing}>
                            Eliminar Cuenta
                        </DangerButton>
                    </div>
                </form>
            </Modal>
        </section>
    );
}
