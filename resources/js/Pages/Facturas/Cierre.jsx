import PrimaryButton from "@/Components/Buttons/PrimaryButton";
import SecondaryButton from "@/Components/Buttons/SecondaryButton";
import InputLabel from "@/Components/Form/InputLabel";
import TextSpan from "@/Components/Form/TextSpan";
import { toCurrency } from "@/Helpers/Numbers";
import axios from "axios";
import React from "react";
import { useState, useEffect } from "react";

export const Cierre = ({ auth, setIsOpen }) => {
    const [total, setTotal] = useState(0);
    
    const onGetReporte = async () => {
        const {
            data: { data },
        } = await axios.post("/api/v1/facturas/cierre");

        const sum = data.map((item) => {
            item.detalles.forEach((_item) => {
                let impuestos = 0;

                _item.producto?.impuestos.forEach((impto) => {
                    if (impto.impuesto?.tipo_impuesto == "I") {
                        if (impto.impuesto.tipo_tarifa == "P") {
                            impuestos +=
                                ((_item.precio_venta || 0) *
                                    Number(impto.impuesto.tarifa)) /
                                100;
                        } else if (impto.impuesto.tipo_tarifa == "V") {
                            impuestos += Number(impto.impuesto.tarifa);
                        }
                    }
                });

                _item.total_impuestos = impuestos;
            });

            return (
                item.detalles.reduce(
                    (sum, det) =>
                        sum +
                        det.precio_venta * det.cantidad +
                        det.total_impuestos * det.cantidad,
                    0
                ) || 0
            );
        });

        if (sum.length) {
            const total = sum.reduce((x, acum) => {
                return x + acum;
            });
            setTotal(toCurrency(total));
        }
    };

    const goToPDF = async () => {
        // window.location.href = "/remisiones/cierre";
        forcePrint( "/remisiones/cierre" )
    };

    useEffect(() => {
        onGetReporte();
    }, []);
    return (
        <div className="pb-12 pt-6">
            <div className="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div className="grid grid-cols-1 gap-4">
                    <div>
                        <InputLabel htmlFor="documento" value="Fecha" />
                        <TextSpan
                            className="mt-1 block w-full"
                            value={new Date().toLocaleDateString()}
                        />
                    </div>

                    <div>
                        <InputLabel
                            htmlFor="documento"
                            value="Total de Ventas a Contado del día"
                        />
                        <TextSpan className="mt-1 block w-full" value={total} />
                    </div>
                </div>

                <div className="flex items-center justify-end mt-4">
                   
                    <PrimaryButton
                        type="button"
                        className="me-3"
                        onClick={() => goToPDF()}
                    >
                        Imprimir
                    </PrimaryButton>

                    <SecondaryButton
                        type="button"
                        onClick={() => setIsOpen(false)}
                    >
                        Ok
                    </SecondaryButton>
                </div>
            </div>
        </div>
    );
};
