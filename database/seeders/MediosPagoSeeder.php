<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediosPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('medios_pagos')->insert([
            ['id' =>1, 'codigo' =>'1' , 'tipo' => 'Instrumento no definido'],
            ['id' =>2, 'codigo' =>'2' , 'tipo' => 'Crédito ACH'],
            ['id' =>3, 'codigo' =>'3' , 'tipo' => 'Débito ACH'],
            ['id' =>4, 'codigo' =>'4' , 'tipo' => 'Reversión débito de demanda ACH'],
            ['id' =>5, 'codigo' =>'5' , 'tipo' => 'Reversión crédito de demanda ACH '],
            ['id' =>6, 'codigo' =>'6' , 'tipo' => 'Crédito de demanda ACH'],
            ['id' =>7, 'codigo' =>'7' , 'tipo' => 'Débito de demanda ACH'],
            ['id' =>8, 'codigo' =>'9' , 'tipo' => 'Clearing Nacional o Regional'],
            ['id' =>9, 'codigo' =>'10' , 'tipo' => 'Efectivo'],
            ['id' =>10, 'codigo' =>'11' , 'tipo' => 'Reversión Crédito Ahorro'],
            ['id' =>11, 'codigo' =>'12' , 'tipo' => 'Reversión Débito Ahorro'],
            ['id' =>12, 'codigo' =>'13' , 'tipo' => 'Crédito Ahorro'],
            ['id' =>13, 'codigo' =>'14' , 'tipo' => 'Débito Ahorro'],
            ['id' =>14, 'codigo' =>'15' , 'tipo' => 'Bookentry Crédito'],
            ['id' =>15, 'codigo' =>'16' , 'tipo' => 'Bookentry Débito'],
            ['id' =>16, 'codigo' =>'17' , 'tipo' => 'Desembolso Crédito (CCD)'],
            ['id' =>17, 'codigo' =>'18' , 'tipo' => 'Desembolso (CCD) débito'],
            ['id' =>18, 'codigo' =>'19' , 'tipo' => 'Crédito Pago negocio corporativo (CTP)'],
            ['id' =>19, 'codigo' =>'20' , 'tipo' => 'Cheque'],
            ['id' =>20, 'codigo' =>'21' , 'tipo' => 'Poyecto bancario'],
            ['id' =>21, 'codigo' =>'22' , 'tipo' => 'Proyecto bancario certificado'],
            ['id' =>22, 'codigo' =>'23' , 'tipo' => 'Cheque bancario de gerencia'],
            ['id' =>23, 'codigo' =>'24' , 'tipo' => 'Nota cambiaria esperando aceptación'],
            ['id' =>24, 'codigo' =>'25' , 'tipo' => 'Cheque certificado'],
            ['id' =>25, 'codigo' =>'26' , 'tipo' => 'Cheque Local'],
            ['id' =>26, 'codigo' =>'27' , 'tipo' => 'Débito Pago Neogcio Corporativo (CTP)'],
            ['id' =>27, 'codigo' =>'28' , 'tipo' => 'Crédito Negocio Intercambio Corporativo (CTX)'],
            ['id' =>28, 'codigo' =>'29' , 'tipo' => 'Débito Negocio Intercambio Corporativo (CTX)'],
            ['id' =>29, 'codigo' =>'30' , 'tipo' => 'Transferencia Crédito'],
            ['id' =>30, 'codigo' =>'31' , 'tipo' => 'Transferencia Débito'],
            ['id' =>31, 'codigo' =>'32' , 'tipo' => 'Desembolso Crédito plus (CCD+)'],
            ['id' =>32, 'codigo' =>'33' , 'tipo' => 'Desembolso Débito plus (CCD+)'],
            ['id' =>33, 'codigo' =>'34' , 'tipo' => 'Pago y depósito pre acordado (PPD)'],
            ['id' =>34, 'codigo' =>'35' , 'tipo' => 'Desembolso Crédito (CCD)'],
            ['id' =>35, 'codigo' =>'36' , 'tipo' => 'Desembolso Débito (CCD)'],
            ['id' =>36, 'codigo' =>'37' , 'tipo' => 'Pago Negocio Corporativo Ahorros Crédito (CTP)'],
            ['id' =>37, 'codigo' =>'38' , 'tipo' => 'Pago Negocio Corporativo Ahorros Débito (CTP)'],
            ['id' =>38, 'codigo' =>'39' , 'tipo' => 'Crédito Intercambio Corporativo (CTX)'],
            ['id' =>39, 'codigo' =>'40' , 'tipo' => 'Débito Intercambio Corporativo (CTX)'],
            ['id' =>40, 'codigo' =>'41' , 'tipo' => 'Desembolso Crédito plus (CCD+)'],
            ['id' =>41, 'codigo' =>'42' , 'tipo' => 'Consiganción bancaria'],
            ['id' =>42, 'codigo' =>'43' , 'tipo' => 'Desembolso Débito plus (CCD+)'],
            ['id' =>43, 'codigo' =>'44' , 'tipo' => 'Nota cambiaria'],
            ['id' =>44, 'codigo' =>'45' , 'tipo' => 'Transferencia Crédito Bancario'],
            ['id' =>45, 'codigo' =>'46' , 'tipo' => 'Transferencia Débito Interbancario'],
            ['id' =>46, 'codigo' =>'47' , 'tipo' => 'Transferencia Débito Bancaria'],
            ['id' =>47, 'codigo' =>'48' , 'tipo' => 'Tarjeta Crédito'],
            ['id' =>48, 'codigo' =>'49' , 'tipo' => 'Tarjeta Débito'],
            ['id' =>49, 'codigo' =>'50' , 'tipo' => 'Postgiro'],
            ['id' =>50, 'codigo' =>'51' , 'tipo' => 'Telex estándar bancario'],
            ['id' =>51, 'codigo' =>'52' , 'tipo' => 'Pago comercial urgente'],
            ['id' =>52, 'codigo' =>'53' , 'tipo' => 'Pago Tesorería Urgente'],
            ['id' =>53, 'codigo' =>'60' , 'tipo' => 'Nota promisoria'],
            ['id' =>54, 'codigo' =>'61' , 'tipo' => 'Nota promisoria firmada por el acreedor'],
            ['id' =>55, 'codigo' =>'62' , 'tipo' => 'Nota promisoria firmada por el acreedor, avalada por el banco'],
            ['id' =>56, 'codigo' =>'63' , 'tipo' => 'Nota promisoria firmada por el acreedor, avalada por un tercero'],
            ['id' =>57, 'codigo' =>'64' , 'tipo' => 'Nota promisoria firmada pro el banco'],
            ['id' =>58, 'codigo' =>'65' , 'tipo' => 'Nota promisoria firmada por un banco avalada por otro banco'],
            ['id' =>59, 'codigo' =>'66' , 'tipo' => 'Nota promisoria firmada '],
            ['id' =>60, 'codigo' =>'67' , 'tipo' => 'Nota promisoria firmada por un tercero avalada por un banco'],
            ['id' =>61, 'codigo' =>'70' , 'tipo' => 'Retiro de nota por el por el acreedor'],
            ['id' =>62, 'codigo' =>'71' , 'tipo' => 'Bonos'],
            ['id' =>63, 'codigo' =>'72' , 'tipo' => 'Vales'],
            ['id' =>64, 'codigo' =>'74' , 'tipo' => 'Retiro de nota por el por el acreedor sobre un banco'],
            ['id' =>65, 'codigo' =>'75' , 'tipo' => 'Retiro de nota por el acreedor, avalada por otro banco'],
            ['id' =>66, 'codigo' =>'76' , 'tipo' => 'Retiro de nota por el acreedor, sobre un banco avalada por un tercero'],
            ['id' =>67, 'codigo' =>'77' , 'tipo' => 'Retiro de una nota por el acreedor sobre un tercero'],
            ['id' =>68, 'codigo' =>'78' , 'tipo' => 'Retiro de una nota por el acreedor sobre un tercero avalada por un banco'],
            ['id' =>69, 'codigo' =>'91' , 'tipo' => 'Nota bancaria transferible'],
            ['id' =>70, 'codigo' =>'92' , 'tipo' => 'Cheque local transferible'],
            ['id' =>71, 'codigo' =>'93' , 'tipo' => 'Giro referenciado'],
            ['id' =>72, 'codigo' =>'94' , 'tipo' => 'Giro urgente'],
            ['id' =>73, 'codigo' =>'95' , 'tipo' => 'Giro formato abierto'],
            ['id' =>74, 'codigo' =>'96' , 'tipo' => 'Método de pago solicitado no usuado'],
            ['id' =>75, 'codigo' =>'97' , 'tipo' => 'Clearing entre partners'],
            ['id' =>76, 'codigo' =>'ZZZ' , 'tipo' => 'Otro'],
        ]);
    }
}