import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/Form/InputError';
import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import TextInput from '@/Components/Form/TextInput';
import { Head, useForm } from '@inertiajs/react';
import SecondaryButton from '@/Components/Buttons/SecondaryButton';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('password.email'));
    };

    const onBack = () => {
        history.back();
    }

    return (
        <GuestLayout>
            <Head title="Forgot Password" />

            <div className="mb-4 text-sm text-gray-600">
                Olvidaste tu contraseña? No hay problema. Escribenos tu correo registrado y te enviaremos un mensaje con un 
                enlace de reseteo de contraseña que te permitirá escoger una nueva.
            </div>

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <form onSubmit={submit}>
                <TextInput
                               placeholder="Escriba aquí"
                    id="email"
                    type="email"
                    name="email"
                    value={data.email}
                    className="mt-1 block w-full"
                    isFocused={true}
                    onChange={(e) => setData('email', e.target.value)}
                />

                <InputError message={errors.email} className="mt-2" />

                <div className="flex items-center justify-end mt-4">
                    <SecondaryButton
                        className="ms-4"
                        onClick={() => onBack()}
                    >
                        Atras
                    </SecondaryButton>
                    
                    <PrimaryButton className="ms-4" disabled={processing}>
                        Enviar Correo
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
