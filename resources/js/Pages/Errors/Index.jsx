import React, { Suspense, useEffect, useState } from "react";
// import Layout from '@/Components/Layout';
import Icon from "@/Components/Icon";
// import SearchFilter from '@/Shared/SearchFilter';

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router } from "@inertiajs/react";
import styles from "./Errors.module.css";

export default ({ auth, error, ...props }) => {
    const [LazyComponent, setLazy] = useState(null);

    const onSetLazy = async () => {
        const module = await import( error);
        const Lazy = module.default;
        setLazyComponent(<Lazy {...props} />);
    }

    useEffect(() => {
        onSetLazy()
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Error Interno...
                </h2>
            }
        >
            <Head title="Ooops..." />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-auto shadow-sm sm:rounded-lg">
                        <div
                            className={`p-6 text-gray-900 ${styles["bg-robot"]}`}
                        >
                            <Suspense fallback={<div>Loading...</div>}>
                                {LazyComponent}
                            </Suspense>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};
