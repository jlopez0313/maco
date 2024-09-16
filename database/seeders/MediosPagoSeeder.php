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
            ['id' =>1, 'codigo' =>'1' , 'descripcion' => 'Instrumento no definido'],
            ['id' =>2, 'codigo' =>'2' , 'descripcion' => 'Crédito ACH'],
            ['id' =>3, 'codigo' =>'3' , 'descripcion' => 'Débito ACH'],
            ['id' =>4, 'codigo' =>'4' , 'descripcion' => 'Reversión débito de demanda ACH'],
            ['id' =>5, 'codigo' =>'5' , 'descripcion' => 'Reversión crédito de demanda ACH '],
            ['id' =>6, 'codigo' =>'6' , 'descripcion' => 'Crédito de demanda ACH'],
            ['id' =>7, 'codigo' =>'7' , 'descripcion' => 'Débito de demanda ACH'],
            ['id' =>8, 'codigo' =>'9' , 'descripcion' => 'Clearing Nacional o Regional'],
            ['id' =>9, 'codigo' =>'10' , 'descripcion' => 'Efectivo'],
            ['id' =>10, 'codigo' =>'11' , 'descripcion' => 'Reversión Crédito Ahorro'],
            ['id' =>11, 'codigo' =>'12' , 'descripcion' => 'Reversión Débito Ahorro'],
            ['id' =>12, 'codigo' =>'13' , 'descripcion' => 'Crédito Ahorro'],
            ['id' =>13, 'codigo' =>'14' , 'descripcion' => 'Débito Ahorro'],
            ['id' =>14, 'codigo' =>'15' , 'descripcion' => 'Bookentry Crédito'],
            ['id' =>15, 'codigo' =>'16' , 'descripcion' => 'Bookentry Débito'],
            ['id' =>16, 'codigo' =>'17' , 'descripcion' => 'Desembolso Crédito (CCD)'],
            ['id' =>17, 'codigo' =>'18' , 'descripcion' => 'Desembolso (CCD) débito'],
            ['id' =>18, 'codigo' =>'19' , 'descripcion' => 'Crédito Pago negocio corporativo (CTP)'],
            ['id' =>19, 'codigo' =>'20' , 'descripcion' => 'Cheque'],
            ['id' =>20, 'codigo' =>'21' , 'descripcion' => 'Poyecto bancario'],
            ['id' =>21, 'codigo' =>'22' , 'descripcion' => 'Proyecto bancario certificado'],
            ['id' =>22, 'codigo' =>'23' , 'descripcion' => 'Cheque bancario de gerencia'],
            ['id' =>23, 'codigo' =>'24' , 'descripcion' => 'Nota cambiaria esperando aceptación'],
            ['id' =>24, 'codigo' =>'25' , 'descripcion' => 'Cheque certificado'],
            ['id' =>25, 'codigo' =>'26' , 'descripcion' => 'Cheque Local'],
            ['id' =>26, 'codigo' =>'27' , 'descripcion' => 'Débito Pago Neogcio Corporativo (CTP)'],
            ['id' =>27, 'codigo' =>'28' , 'descripcion' => 'Crédito Negocio Intercambio Corporativo (CTX)'],
            ['id' =>28, 'codigo' =>'29' , 'descripcion' => 'Débito Negocio Intercambio Corporativo (CTX)'],
            ['id' =>29, 'codigo' =>'30' , 'descripcion' => 'Transferencia Crédito'],
            ['id' =>30, 'codigo' =>'31' , 'descripcion' => 'Transferencia Débito'],
            ['id' =>31, 'codigo' =>'32' , 'descripcion' => 'Desembolso Crédito plus (CCD+)'],
            ['id' =>32, 'codigo' =>'33' , 'descripcion' => 'Desembolso Débito plus (CCD+)'],
            ['id' =>33, 'codigo' =>'34' , 'descripcion' => 'Pago y depósito pre acordado (PPD)'],
            ['id' =>34, 'codigo' =>'35' , 'descripcion' => 'Desembolso Crédito (CCD)'],
            ['id' =>35, 'codigo' =>'36' , 'descripcion' => 'Desembolso Débito (CCD)'],
            ['id' =>36, 'codigo' =>'37' , 'descripcion' => 'Pago Negocio Corporativo Ahorros Crédito (CTP)'],
            ['id' =>37, 'codigo' =>'38' , 'descripcion' => 'Pago Negocio Corporativo Ahorros Débito (CTP)'],
            ['id' =>38, 'codigo' =>'39' , 'descripcion' => 'Crédito Intercambio Corporativo (CTX)'],
            ['id' =>39, 'codigo' =>'40' , 'descripcion' => 'Débito Intercambio Corporativo (CTX)'],
            ['id' =>40, 'codigo' =>'41' , 'descripcion' => 'Desembolso Crédito plus (CCD+)'],
            ['id' =>41, 'codigo' =>'42' , 'descripcion' => 'Consiganción bancaria'],
            ['id' =>42, 'codigo' =>'43' , 'descripcion' => 'Desembolso Débito plus (CCD+)'],
            ['id' =>43, 'codigo' =>'44' , 'descripcion' => 'Nota cambiaria'],
            ['id' =>44, 'codigo' =>'45' , 'descripcion' => 'Transferencia Crédito Bancario'],
            ['id' =>45, 'codigo' =>'46' , 'descripcion' => 'Transferencia Débito Interbancario'],
            ['id' =>46, 'codigo' =>'47' , 'descripcion' => 'Transferencia Débito Bancaria'],
            ['id' =>47, 'codigo' =>'48' , 'descripcion' => 'Tarjeta Crédito'],
            ['id' =>48, 'codigo' =>'49' , 'descripcion' => 'Tarjeta Débito'],
            ['id' =>49, 'codigo' =>'50' , 'descripcion' => 'Postgiro'],
            ['id' =>50, 'codigo' =>'51' , 'descripcion' => 'Telex estándar bancario'],
            ['id' =>51, 'codigo' =>'52' , 'descripcion' => 'Pago comercial urgente'],
            ['id' =>52, 'codigo' =>'53' , 'descripcion' => 'Pago Tesorería Urgente'],
            ['id' =>53, 'codigo' =>'60' , 'descripcion' => 'Nota promisoria'],
            ['id' =>54, 'codigo' =>'61' , 'descripcion' => 'Nota promisoria firmada por el acreedor'],
            ['id' =>55, 'codigo' =>'62' , 'descripcion' => 'Nota promisoria firmada por el acreedor, avalada por el banco'],
            ['id' =>56, 'codigo' =>'63' , 'descripcion' => 'Nota promisoria firmada por el acreedor, avalada por un tercero'],
            ['id' =>57, 'codigo' =>'64' , 'descripcion' => 'Nota promisoria firmada pro el banco'],
            ['id' =>58, 'codigo' =>'65' , 'descripcion' => 'Nota promisoria firmada por un banco avalada por otro banco'],
            ['id' =>59, 'codigo' =>'66' , 'descripcion' => 'Nota promisoria firmada '],
            ['id' =>60, 'codigo' =>'67' , 'descripcion' => 'Nota promisoria firmada por un tercero avalada por un banco'],
            ['id' =>61, 'codigo' =>'70' , 'descripcion' => 'Retiro de nota por el por el acreedor'],
            ['id' =>62, 'codigo' =>'71' , 'descripcion' => 'Bonos'],
            ['id' =>63, 'codigo' =>'72' , 'descripcion' => 'Vales'],
            ['id' =>64, 'codigo' =>'74' , 'descripcion' => 'Retiro de nota por el por el acreedor sobre un banco'],
            ['id' =>65, 'codigo' =>'75' , 'descripcion' => 'Retiro de nota por el acreedor, avalada por otro banco'],
            ['id' =>66, 'codigo' =>'76' , 'descripcion' => 'Retiro de nota por el acreedor, sobre un banco avalada por un tercero'],
            ['id' =>67, 'codigo' =>'77' , 'descripcion' => 'Retiro de una nota por el acreedor sobre un tercero'],
            ['id' =>68, 'codigo' =>'78' , 'descripcion' => 'Retiro de una nota por el acreedor sobre un tercero avalada por un banco'],
            ['id' =>69, 'codigo' =>'91' , 'descripcion' => 'Nota bancaria transferible'],
            ['id' =>70, 'codigo' =>'92' , 'descripcion' => 'Cheque local transferible'],
            ['id' =>71, 'codigo' =>'93' , 'descripcion' => 'Giro referenciado'],
            ['id' =>72, 'codigo' =>'94' , 'descripcion' => 'Giro urgente'],
            ['id' =>73, 'codigo' =>'95' , 'descripcion' => 'Giro formato abierto'],
            ['id' =>74, 'codigo' =>'96' , 'descripcion' => 'Método de pago solicitado no usuado'],
            ['id' =>75, 'codigo' =>'97' , 'descripcion' => 'Clearing entre partners'],
            ['id' =>76, 'codigo' =>'ZZZ' , 'descripcion' => 'Otro'],
        ]);
    }
}