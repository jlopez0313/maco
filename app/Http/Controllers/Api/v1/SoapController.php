<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Empresas;
use App\Models\Clientes;
use App\Models\Consecutivos;
use App\Models\Credenciales;
use App\Models\Facturas;
use App\Models\Productos;
use App\Models\Proveedores;
// use SoapClient;


class SoapController extends Controller
{
    public function generarNumeracion()
    {
        try {
            // $wsdlUrl = 'https://webservice.facturatech.co/v2/BETA/WSV2DEMO.asmx?WSDL';
            $wsdlUrl = 'https://webservice.facturatech.co/v2/BETA/SincronizacionNumeracion.asmx?wsdl';

            $soapClientOptions = [
                'encoding' => 'UTF-8',
                'soap_version' => 'SOAP_1_2',
                'trace' => 1,
                'exceptions' => 1,
                'connection_timeout' => 100,
                'soap.wsdl_cache_enabled' => '0',
            ];

            $client = new \SoapClient($wsdlUrl, $soapClientOptions);

            $credenciales = Credenciales::where('estado', 'A')->first();

            $result = $client->__soapCall('GenerarNumeracion', [
                'User' => $credenciales->username,
                'Pass' => $credenciales->password,
                'Prefijo' => 'MACO',
                'NumeroInicial' => 1,
                'NumeroFinal' => 1000,
                'TipoDocumento' => 'INVOIC',
            ]);

            return $result;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function consultaNumeracion()
    {
        try {
            // $wsdlUrl = 'https://webservice.facturatech.co/v2/BETA/WSV2DEMO.asmx?WSDL';
            $wsdlUrl = 'https://webservice.facturatech.co/v2/BETA/SincronizacionNumeracion.asmx?wsdl';

            $soapClientOptions = [
                'encoding' => 'UTF-8',
                'soap_version' => 'SOAP_1_2',
                'trace' => 1,
                'exceptions' => 1,
                'connection_timeout' => 100,
                'soap.wsdl_cache_enabled' => '0',
            ];

            $client = new \SoapClient($wsdlUrl, $soapClientOptions);
            
            $credenciales = Credenciales::where('estado', 'A')->first();

            $result = $client->__soapCall('ConsultaNumeracion', [
                'User' => $credenciales->username,
                'Pass' => $credenciales->password,
            ]);

            return $result;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function actualizarNumTipoDocumento()
    {
        try {
            // $wsdlUrl = 'https://webservice.facturatech.co/v2/BETA/WSV2DEMO.asmx?WSDL';
            $wsdlUrl = 'https://ws.facturatech.co/v2/demo/index.php?wsdl';

            $soapClientOptions = [
                'encoding' => 'UTF-8',
                'soap_version' => 'SOAP_1_2',
                'trace' => 1,
                'exceptions' => 1,
                'connection_timeout' => 100,
                'soap.wsdl_cache_enabled' => '0',
            ];

            $client = new \SoapClient($wsdlUrl, $soapClientOptions);

            $credenciales = Credenciales::where('estado', 'A')->first();

            $result = $client->__soapCall('FtechAction.uploadInvoiceFile', [
                'User' => $credenciales->username,
                'Pass' => $credenciales->password,
                'Prefijo' => 'MACO',
                'NumAutorizacion' => '1001',
                'TipoDocumento' => 'INVOIC',
            ]);

            return $result;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    // Paso 1. uploadInvoiceFile
    public function upload( $id )
    {
        try {
            // $wsdlUrl = 'https://webservice.facturatech.co/v2/BETA/WSV2DEMO.asmx?WSDL';
            $wsdlUrl = 'https://ws.facturatech.co/v2/demo/index.php?wsdl';

            $soapClientOptions = [
                'encoding' => 'UTF-8',
                'soap_version' => 'SOAP_1_2',
                'trace' => 1,
                'exceptions' => 1,
                'connection_timeout' => 100,
                'soap.wsdl_cache_enabled' => '0',
            ];

            $client = new \SoapClient($wsdlUrl, $soapClientOptions);
    
    /*
                $xml = '<?xml version="1.0" encoding="UTF-8"?> <!-- FACTURA DE EXPORTACION V1.9 -->
                <FACTURA>
                  <ENC>                                       <!-- ENCABEZADO -->
                      <ENC_1>INVOIC</ENC_1>                     <!-- Tipo de Documento - Excel Simplificado Anexo - Estandar Simplificado - OK Constante -->
                      <ENC_2>901143311</ENC_2>                  <!-- NIT CUENTA DEMO 901143311 - OK Constante para Pruebas 901143311 --> 
                      <ENC_3>1061710433</ENC_3>                 <!-- NIT ADQUIRIENTE/CLIENTE FINAL - OK -->
                      <ENC_4>UBL 2.1</ENC_4>                    <!-- Constante - OK -->
                      <ENC_5>DIAN 2.1</ENC_5>                   <!-- Constante - OK -->
                      <ENC_6>TCFA39501</ENC_6>                  <!-- Prefijo y numero de factura - OK -->
                      <ENC_9>01</ENC_9>                         <!-- Tipo de Factura - Excel Simplificado Anexo - Estandar Simplificado - OK Constante -->
                      <ENC_10>COP</ENC_10>                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK-->
                      <ENC_11>2021-07-25T11:27:49</ENC_11>      <!-- Fecha y hora inicio del período facturado - OK -->
                      <ENC_12>2021-07-25T11:27:49</ENC_12>      <!-- Fecha y hora fin del período facturado - OK -->
                      <ENC_15>1</ENC_15>                        <!-- Número de lineas en el detalle - OK Calculado -->
                      <ENC_16>2021-07-25</ENC_16>               <!-- Fecha de Vencimiento de la factura - OK -->
                      <ENC_20>2</ENC_20>                        <!-- Tabla 28 - Ambiente Destino Del Documento - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                      <ENC_21>10</ENC_21>                       <!-- Tabla 38 - Tipo de operación - Tablas 2.1 - OK Constante -->
                  </ENC>
                  <EMI>                                       <!-- EMISOR -->
                      <EMI_1>1</EMI_1>                          <!-- Tabla 20  Tipo de identificación - Tipos de Persona - Tablas 2.1 - OK -->
                      <EMI_2>901143311</EMI_2>                  <!-- NIT Emisor - RUT - OK Constante para Pruebas 901143311 --> 
                      <EMI_3>31</EMI_3>                         <!-- Tabla 3 - Tipos de documentos de identidad - Tablas 2.1 - OK -->
                      <EMI_6>FACTURATECH SA. DE CV</EMI_6>      <!-- Nombre Emisor - RUT - OK -->
                      <EMI_7>FACTURATECH SA. DE CV</EMI_7>      <!-- Nombre Comercial - RUT - OK -->
                      <EMI_10>CALLE 5 #38A-13</EMI_10>          <!-- Dirección Comercial - OK -->
                      <EMI_11>19</EMI_11>                       <!-- Tabla 34 - Departamentos - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                      <EMI_13>POPAYÁN</EMI_13>                  <!-- Tabla 35 - Municipios - Nombre Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                      <EMI_15>CO</EMI_15>                       <!-- Tabla 1 - Códigos de países - Alfa2 - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                      <EMI_19>CAUCA</EMI_19>                    <!-- Tabla 34 - Departamentos - Nombre - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                      <EMI_22>8</EMI_22>                        <!-- DV RUT - OK -->
                      <EMI_23>19001</EMI_23>                    <!-- Tabla 35 - Municipios - Código Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                      <EMI_24>FACTURATECH SA. DE CV</EMI_24>    <!-- Nombre Emisor - o Nombre Comercial - RUT - OK -->
                      <TAC>                                   <!-- INFORMACION TRIBUTARIA EMISOR -->
                        <TAC_1>R-99-PN</TAC_1>                  <!-- Tabla 36 Responsabilidades Fiscales - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                      </TAC>
                      <DFE>                                   <!-- INFORMACION FISCAL EMISOR -->
                        <DFE_1>19001</DFE_1>                    <!-- Tabla 35 - Municipios - Código Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                        <DFE_2>19</DFE_2>                       <!-- Tabla 34 - Departamentos - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                        <DFE_3>CO</DFE_3>                       <!-- Tabla 1 - Códigos de países - Alfa2 - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                        <DFE_4>190003</DFE_4>                   <!-- Tabla 39 - Código Postal - Excel Simplificado Anexo - Tablas 2.1 - OK Constante Tabla 35 -->
                        <DFE_5>Colombia</DFE_5>                 <!-- Tabla 1 - Códigos de países - Nombre Común - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                        <DFE_6>CAUCA</DFE_6>                    <!-- Tabla 34 - Departamentos - Nombre- Excel Simplificado Anexo - Tablas 2.1 - OK -->            
                        <DFE_7>POPAYÁN</DFE_7>                  <!-- Tabla 35 - Municipios - Nombre Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                        <DFE_8>CALLE 5 #38A-13</DFE_8>          <!-- Dirección - OK -->
                      </DFE>
                      <ICC>                                   <!-- INFORMACION CAMARA DE COMERCIO EMISOR -->
                        <ICC_1>125546877</ICC_1>                <!-- Número de matrícula mercantil (Identificador de sucursal: Punto de facturación) - OK -->
                        <ICC_9>TCFA</ICC_9>                     <!-- Prefijo - RUT - OK -->
                      </ICC>
                      <CDE>                                   <!-- INFORMACION CONTACTO EMISOR - OPCIONAL -->
                        <CDE_1>1</CDE_1>                        <!-- Tipo de contacto, del emisor - OK Constante -->
                        <CDE_2>LUIS MIUGUEL GONZALEZ</CDE_2>    <!-- Nombre de contacto, del emisor - OK -->
                        <CDE_3>3185222474</CDE_3>               <!-- Celular de contacto, del emisor - OK -->
                        <CDE_4>null</CDE_4>                     <!-- Correo de contacto, del emisor - OK -->
                      </CDE>
                      <GTE>                                   <!-- GRUPO DETALLES TRIBUTARIOS EMISOR -->
                        <GTE_1>1</GTE_1>                        <!-- Tabla 11 - código - Impuestos registrados en la Factura Electrónica - OK -->
                        <GTE_2>IVA</GTE_2>                      <!-- Tabla 11 - nombre - Impuestos registrados en la Factura Electrónica - OK -->
                      </GTE>
                  </EMI>
                  <ADQ>                                       <!-- ADQUIRIENTE -->
                      <ADQ_1>1</ADQ_1>                          <!-- Tabla 20 Tipo de identificación - Tipos de Persona - codigo de cliente - OK -->
                      <ADQ_2>123456789</ADQ_2>                  <!-- Numero de Documento de cliente - OK -->
                      <ADQ_3>31</ADQ_3>                         <!-- Tabla 3 - Tipos de documentos de identidad - OK -->
                      <ADQ_6>varios null varios</ADQ_6>         <!-- Nombre del Cliente - RUT - OK -->
                      <ADQ_7>varios null varios</ADQ_7>         <!-- Nombre comercial del Cliente - RUT - OK -->
                      <ADQ_10>calle 123</ADQ_10>                <!-- dirección - OK -->
                      <ADQ_11>19</ADQ_11>                       <!-- Tabla 34 - Departamentos - codigo - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                      <ADQ_13>N/A</ADQ_13>                      <!-- Tabla 35 - Municipios - Nombre Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                      <ADQ_14>190003</ADQ_14>                   <!-- Tabla 39 - Código Postal - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                      <ADQ_15>CO</ADQ_15>                       <!-- Tabla 1 - Códigos de países - Alfa2 - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                      <ADQ_19>undefined</ADQ_19>                <!-- Tabla 34 - Departamentos - nombre - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                      <ADQ_21>Colombia</ADQ_21>                 <!-- Tabla 1 - Códigos de países - Nombre Común - Excel Simplificado Anexo - Tablas 2.1 - OK Cosntante -->
                      <ADQ_22>1</ADQ_22>                        <!-- DV Cliente - RUT - OK -->
                      <ADQ_23>19001</ADQ_23>                    <!-- Tabla 35 - Municipios - Código Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK --> 
                      <TCR>                                   <!-- INFORMACION TRIBUTARIA ADQUIRIENTE -->
                        <TCR_1>R-99-PN</TCR_1>                  <!-- Tabla 36 Responsabilidades Fiscales - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                      </TCR>
                      <ILA>                                   <!-- INFORMACION LEGAL ADQUIRIENTE -->
                        <ILA_1>varios null varios</ILA_1>       <!-- Nombre del Cliente - RUT - OK -->
                        <ILA_2>123456789</ILA_2>                <!-- Numero de Documento de cliente - OK -->
                        <ILA_3>31</ILA_3>                       <!-- Tabla 3 - Tipos de documentos de identidad - OK -->
                        <ILA_4>1</ILA_4>                        !-- DV Cliente - RUT - OK -->
                      </ILA>
                      <DFA>                                    <!-- INFORMACION FISCAL ADQUIRIENTE - OPCIONAL -->
                        <DFA_1>CO</DFA_1>                       <!-- Tabla 1 - Códigos de países - Alfa2 - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                        <DFA_2>19</DFA_2>                       <!-- Tabla 34 - Departamentos - codigo - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                        <DFA_3>190003</DFA_3>                   <!-- Tabla 39 - Código Postal - Excel Simplificado Anexo - Tablas 2.1 - OK Constante Tabla 35 -->
                        <DFA_4>19001</DFA_4>                    <!-- Tabla 35 - Municipios - Código Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK --> 
                        <DFA_5>Colombia</DFA_5>                 <!-- Tabla 1 - Códigos de países - Nombre Común - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                        <DFA_6>undefined</DFA_6>                <!-- Tabla 34 - Departamentos - nombre - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                        <DFA_7>N/A</DFA_7>                      <!-- Tabla 35 - Municipios - Nombre Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                        <DFA_8>calle 123</DFA_8>                <!-- dirección - OK -->
                      </DFA>
                      <ICR>                                     
                        <ICR_1>784112</ICR_1>                 <!-- INFORMACION CAMARA DE COMERCIO ADQUIRIENTE - OK -->
                      </ICR>
                      <CDA>                                   <!-- INFORMACION CONTACTO ADQUIRIENTE - OPCIONAL -->
                        <CDA_1>1</CDA_1>                        <!-- Tipo de Contacto - Excel Simplificado Anexo - OK Constante -->
                        <CDA_2>varios null varios</CDA_2>       <!-- Nombre de contacto, del cliente - OK -->
                        <CDA_3>583100</CDA_3>                   <!-- Celular de contacto, del cliente - OK -->
                        <CDA_4>null</CDA_4>                     <!-- Correo de contacto, del cliente - OK -->
                      </CDA>
                      <GTA>                                   <!-- GRUPO DETALLES TRIBUTARIOS ADQUIRIENTE -->
                        <GTA_1>1</GTA_1>                        <!-- Tabla 11 - código - Impuestos registrados en la Factura Electrónica - OK -->
                        <GTA_2>IVA</GTA_2>                      <!-- Tabla 11 - nombre - Impuestos registrados en la Factura Electrónica - OK -->
                      </GTA>
                  </ADQ>
                  <TOT>                                       <!-- TOTALES -->
                      <TOT_1>100000</TOT_1>                     <!-- Total Bruto -->
                      <TOT_2>COP</TOT_2>                        <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                      <TOT_3>100000</TOT_3>                     <!-- Total Base -->
                      <TOT_4>COP</TOT_4>                        <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                      <TOT_5>119000</TOT_5>                     <!--Gran Total -->
                      <TOT_6>COP</TOT_6>                        <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                      <TOT_7>119000</TOT_7>                     <!-- Total Brutos + impuestos -->
                      <TOT_8>COP</TOT_8>                        <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                  </TOT>
                  <TIM>                                       <!-- TOTAL IMPUESTOS -->
                    <TIM_1>false</TIM_1>                        <!-- Es Impuesto Retenido? - OK -->
                    <TIM_2>19000</TIM_2>                        <!-- Total impuestos -->
                    <TIM_3>COP</TIM_3>                          <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                    <IMP>                                     <!-- IMPUESTOS -->
                      <IMP_1>01</IMP_1>                         <!-- Tabla 44 - Impuestos registrados en la Factura Electrónica - Tablas 2.1 - OK -->
                      <IMP_2>100000.00</IMP_2>                  <!-- Total Base -->
                      <IMP_3>COP</IMP_3>                        <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                      <IMP_4>19000</IMP_4>                      <!-- Total impuestos -->
                      <IMP_5>COP</IMP_5>                        <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                      <IMP_6>19.00</IMP_6>                      <!-- Tabla 32 - Tarifas por Impuesto - TARIFA - Tablas 2.1 - OK -->
                    </IMP>
                  </TIM>
                  <TDC>                                       <!-- TIPO DE CAMBIO - OPCIONAL -->
                    <TDC_1>USD</TDC_1>                          <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 -->
                    <TDC_3>3883.89</TDC_3>                      <!-- Tipo de cambio al dia -->
                    <TDCE>
                            <TDCE_1>25.74</TDCE_1>              <!-- TDCE_1 = SUM(ITE_7 * ITE_27)/TDC_3-->
                            <TDCE_2>0.00</TDCE_2>               <!-- TDCE_2= Total descuentos a detalle / TDC_3 -->
                            <TDCE_3>0.00</TDCE_3>               <!-- TDCE_3= total recargos a detalle / TDC_3 -->
                            <TDCE_4>25.74</TDCE_4>              <!-- TDCE_4= TDCE_1+ TDCE_3 - TDCE_2 -->
                            <TDCE_5>4.89</TDCE_5>               <!-- TDCE_5= TIM_2 / TDC_3 cuando IMP_1 = 01(IVA) -->
                            <TDCE_6>0.00</TDCE_6>               <!-- TDCE_6= TIM_2 / TDC_3 cuando IMP_1 = 03(INC) -->
                            <TDCE_7>0.00</TDCE_7>               <!-- TDCE_7= TIM_2 / TDC_3 cuando IMP_1 = 22(Impuesto a la bolsa) -->
                            <TDCE_8>0.00</TDCE_8>               <!-- TDCE_8= Sumatoria de los impuestos no clasificados anteriormente, cuado no sea ningun de 01 , 03 y 22 -->
                            <TDCE_9>4.89</TDCE_9>               <!-- TDCE_9 = TDCE_5 + TDCE_6 + TDCE_7 + TDCE_8 -->
                            <TDCE_10>30.63</TDCE_10>            <!-- DCE_10= TDCE_4 + TDCE_5 + TDCE_6 + TDCE_7 + TDCE_8 ó TDCE_10= TDCE_4 + TDCE_9 -->
                            <TDCE_11>0.00</TDCE_11>             <!-- TTDCE_11 = SUM(DSC_3)/TDC_3 cuando DSC_1 == false -->
                            <TDCE_12>0.00</TDCE_12>             <!-- TDCE_12 = SUM(DSC_3)/TDC_3 cuando DSC_1 == true -->
                            <TDCE_13>30.63</TDCE_13>            <!-- DCE_13= TDCE_10 + TDCE_12 - TDCE_11 -->
                            <TDCE_14>0.00</TDCE_14>             <!-- TDCE_14= TIM_2 / TDC_3 cuando IMP_1 = 06(RETE_FUENTE) -->
                            <TDCE_15>0.00</TDCE_15>             <!-- TDCE_15= TIM_2 / TDC_3 cuando IMP_1 = 05(RETE_IVA)  -->
                            <TDCE_16>0.00</TDCE_16>             <!-- TDCE_16= TIM_2 / TDC_3 cuando IMP_1 = 07(RETE_ICA)  -->
                            <TDCE_17>0.00</TDCE_17>             <!-- Total Anticipos = TOT_13 / TDC_3 -->            
                    </TDCE>
                  </TDC>
                  <DRF>                                       <!-- RESOLUCIÓN DIAN -->
                      <DRF_1>201911110152</DRF_1>               <!-- Número de Resolución DIAN - OK -->
                      <DRF_2>2019-11-11</DRF_2>                 <!-- Fecha inicial Resolución - OK -->
                      <DRF_3>2030-12-31</DRF_3>                 <!-- Fecha final Resolución - OK -->
                      <DRF_4>TCFA</DRF_4>                       <!-- Prefijo Resolución - OK -->
                      <DRF_5>39501</DRF_5>                      <!-- Consecutivo Inicial - OK -->
                      <DRF_6>39600</DRF_6>                      <!-- Consecutivo Final - OK -->
                  </DRF>
                  <MEP>                                       <!-- MEDIOS DE PAGO -->
                      <MEP_1>10</MEP_1>                         <!-- Tabla 5 - Códigos Medios de pago - Código / Code - Tablas 2.1 - OK -->
                      <MEP_2>1</MEP_2>                          <!-- Tabla 26 - Formas de Pago - Código - Tablas 2.1 - OK -->
                      <MEP_3>2023-10-03T07:52:52.653Z</MEP_3>   <!-- Fecha de Pago -->
                  </MEP>
                  <ITE>                                       <!-- ITEMS DEL DOCUMENTO - ITERATIVO - OK Calculado -->
                      <ITE_1>1</ITE_1>                          <!-- Número de Línea -->
                      <ITE_3>1</ITE_3>                          <!-- Cantidad total -->
                      <ITE_4>94</ITE_4>                         <!-- Tabla 12 - Unidades de medida - Código - Tablas 2.1 - OK -->
                      <ITE_5>100000</ITE_5>                     <!-- Precio Unitario * cantidad -->
                      <ITE_6>COP</ITE_6>                        <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                      <ITE_7>100</ITE_7>                        <!-- Precio Unitario - OK -->
                      <ITE_8>COP</ITE_8>                        <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                      <ITE_11>producto prueba precios</ITE_11>  <!-- Descripcion del producto -->
                      <ITE_20>COP</ITE_20>                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                      <ITE_21>119000.00</ITE_21>                <!-- Valor Total  -->
                      <ITE_24>COP</ITE_24>                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                      <ITE_27>1000</ITE_27>                     <!-- Cantidad total -->
                      <ITE_28>94</ITE_28>                       <!-- Tabla 12 - Unidades de medida - Código - Tablas 2.1 - OK -->
                      <IAE>                                   <!-- IDENTIFICACION DEL ARTICULO -->
                        <IAE_1>10</IAE_1>                       <!-- Tabla 31 - Productos - Código - Tablas 2.1 -->
                        <IAE_2>999</IAE_2>                      <!-- Tabla 31 - Productos - Código - Tablas 2.1 -->
                      </IAE>
                      <TII>                                   <!-- TOTAL IMPUESTOS - OK Calculado -->
                        <TII_1>19000.00</TII_1>                 <!-- Cantidad total -->
                        <TII_2>COP</TII_2>                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                        <TII_3>false</TII_3>                    <!-- Es Impuesto Retenido? - OK -->
                        <IIM>                                 <!-- IMPUESTOS -->
                            <IIM_1>01</IIM_1>                   <!-- Tabla 44 - Impuestos registrados en la Factura Electrónica - Tablas 2.1 - OK -->
                            <IIM_2>19000.00</IIM_2>             <!-- Total Impuesto -->
                            <IIM_3>COP</IIM_3>                  <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                            <IIM_4>100000</IIM_4>               <!-- Total Base -->
                            <IIM_5>COP</IIM_5>                  <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                            <IIM_6>19.00</IIM_6>                <!-- Tabla 32 - Tarifas por Impuesto - TARIFA - Tablas 2.1 - OK -->
                        </IIM>
                      </TII>
                  </ITE>
                </FACTURA>
                ';
    */
    
            $factura = Facturas::with('detalles.producto.unidad_medida', 'detalles.producto.medida', 'detalles.producto.impuestos')->find($id);
            $createdAt = \Carbon\Carbon::parse($factura->created_at);
            
            $consecutivo = Consecutivos::first();

            $emisor = Empresas::with('tipo', 'responsabilidad', 'tipo_doc', 'ciudad.departamento', 'contacto', 'resolucion')
            ->first();

            $adquiriente = Clientes::with('tipo', 'responsabilidad', 'tipo_doc', 'ciudad.departamento', 'contacto')
            ->find($factura->clientes_id);

            // return [$emisor, $adquiriente, $consecutivo, $emisor->resolucion->prefijo . ($consecutivo->consecutivo ?? 1)];

            $xml = '<?xml version="1.0" encoding="UTF-8"?> <!-- FACTURA DE EXPORTACION V1.9 -->
            <FACTURA>
            <ENC>                                           <!-- ENCABEZADO -->
                <ENC_1>INVOIC</ENC_1>                                                       <!-- Tipo de Documento - Excel Simplificado Anexo - Estandar Simplificado - OK Constante -->
                <ENC_2>'.$emisor->documento.'</ENC_2>                                       <!-- NIT Emisor - OK - para Pruebas 901143311 --> 
                <ENC_3>'.$adquiriente->documento.'</ENC_3>                                  <!-- NIT ADQUIRIENTE/CLIENTE FINAL - OK -->
                <ENC_4>UBL 2.1</ENC_4>                                                      <!-- Constante - OK -->
                <ENC_5>DIAN 2.1</ENC_5>                                                     <!-- Constante - OK -->
                <ENC_6>'. $emisor->resolucion->prefijo . ($consecutivo->consecutivo ?? 1) .'</ENC_6>                                              <!-- Prefijo y numero de factura - OK -->
                <ENC_9>01</ENC_9>                                                           <!-- Tipo de Factura - Excel Simplificado Anexo - Estandar Simplificado - OK Constante -->
                <ENC_10>COP</ENC_10>                                                        <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                <!-- <ENC_11>2021-07-25T11:27:49</ENC_11> -->                               <!-- Fecha y hora inicio del período facturado - OK -->
                <!-- <ENC_12>2021-07-25T11:27:49</ENC_12> -->                               <!-- Fecha y hora fin del período facturado - OK -->
                <ENC_15>'. count($factura->detalles) .'</ENC_15>                            <!-- Número de lineas en el detalle - OK Calculado -->
                <ENC_16>2021-07-25</ENC_16>                                                 <!-- Fecha de Vencimiento de la factura - OK -->
                <ENC_20>2</ENC_20>                                                          <!-- Tabla 28 - Ambiente Destino Del Documento - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                <ENC_21>10</ENC_21>                                                         <!-- Tabla 38 - Tipo de operación - Tablas 2.1 - OK Constante -->
            </ENC>
            <EMI>                                           <!-- EMISOR -->
                <EMI_1>'. $emisor->tipo->codigo .'</EMI_1>                                  <!-- Tabla 20  Tipo de identificación - Tipos de Persona - Tablas 2.1 - OK -->
                <EMI_2>'.$emisor->documento.'</EMI_2>                                       <!-- NIT Emisor - RUT - OK - para Pruebas 901143311 --> 
                <EMI_3>'. $emisor->tipo_doc->codigo .'</EMI_3>                              <!-- Tabla 3 - Tipos de documentos de identidad - Tablas 2.1 - OK -->
                <EMI_6>'. $emisor->nombre .'</EMI_6>                                        <!-- Nombre Emisor - RUT - OK -->
                <EMI_7>'. $emisor->comercio .'</EMI_7>                                      <!-- Nombre Comercial - RUT - OK -->
                <EMI_10>'. $emisor->direccion .'</EMI_10>                                   <!-- Dirección Comercial - OK -->
                <EMI_11>'. $emisor->ciudad->departamento->codigo .'</EMI_11>                <!-- Tabla 34 - Departamentos - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                <EMI_13>'. $emisor->ciudad->ciudad .'</EMI_13>                              <!-- Tabla 35 - Municipios - Nombre Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                <EMI_15>CO</EMI_15>                                                         <!-- Tabla 1 - Códigos de países - Alfa2 - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                <EMI_19>'. $emisor->ciudad->departamento->departamento .'</EMI_19>          <!-- Tabla 34 - Departamentos - Nombre - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                <EMI_22>'. $emisor->dv .'</EMI_22>                                          <!-- DV RUT - OK -->
                <EMI_23>'. $emisor->ciudad->codigo .'</EMI_23>                              <!-- Tabla 35 - Municipios - Código Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                <EMI_24>'. $emisor->nombre .'</EMI_24>                                      <!-- Nombre Emisor - o Nombre Comercial - RUT - OK -->
                <TAC>                                       <!-- INFORMACION TRIBUTARIA EMISOR -->
                    <TAC_1>'. $emisor->responsabilidad->codigo .'</TAC_1>                   <!-- Tabla 36 Responsabilidades Fiscales - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                </TAC>
                <DFE>                                       <!-- INFORMACION FISCAL EMISOR -->
                    <DFE_1>'. $emisor->ciudad->codigo .'</DFE_1>                            <!-- Tabla 35 - Municipios - Código Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                    <DFE_2>'. $emisor->ciudad->departamento->codigo .'</DFE_2>                  <!-- Tabla 34 - Departamentos - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                    <DFE_3>CO</DFE_3>                                                       <!-- Tabla 1 - Códigos de países - Alfa2 - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                    <DFE_4>190003</DFE_4>                                                   <!-- Tabla 39 - Código Postal - Excel Simplificado Anexo - Tablas 2.1 - OK Constante Tabla 35 -->
                    <DFE_5>Colombia</DFE_5>                                                 <!-- Tabla 1 - Códigos de países - Nombre Común - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                    <DFE_6>'. $emisor->ciudad->departamento->departamento .'</DFE_6>        <!-- Tabla 34 - Departamentos - Nombre- Excel Simplificado Anexo - Tablas 2.1 - OK -->            
                    <DFE_7>'. $emisor->ciudad->ciudad .'</DFE_7>                            <!-- Tabla 35 - Municipios - Nombre Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                    <DFE_8>'. $emisor->direccion .'</DFE_8>                                 <!-- Dirección - OK -->
                </DFE>
                <ICC>                                       <!-- INFORMACION CAMARA DE COMERCIO EMISOR -->
                    <ICC_1>'. $emisor->matricula .'</ICC_1>                                 <!-- Número de matrícula mercantil (Identificador de sucursal: Punto de facturación) - OK -->
                    <ICC_9>'. $emisor->resolucion->prefijo .'</ICC_9>                       <!-- Prefijo - RUT - OK -->
                </ICC>
                <CDE>                                       <!-- INFORMACION CONTACTO EMISOR - OPCIONAL -->
                    <CDE_1>1</CDE_1>                                                        <!-- Tipo de contacto, del emisor - OK Constante -->
                    <CDE_2>'. ($emisor->contacto->nombre  ?? '').'</CDE_2>                  <!-- Nombre de contacto, del emisor - OK -->
                    <CDE_3>'. ($emisor->contacto->celular ?? '') .'</CDE_3>                 <!-- Celular de contacto, del emisor - OK -->
                    <CDE_4>'. ($emisor->contacto->correo  ?? '').'</CDE_4>                  <!-- Correo de contacto, del emisor - OK -->
                </CDE>
                <GTE>                                       <!-- GRUPO DETALLES TRIBUTARIOS EMISOR -->
                    <GTE_1>1</GTE_1>                                                        <!-- Tabla 11 - código - Impuestos registrados en la Factura Electrónica - OK -->
                    <GTE_2>IVA</GTE_2>                                                      <!-- Tabla 11 - nombre - Impuestos registrados en la Factura Electrónica - OK -->
                </GTE>
            </EMI>
            <ADQ>                                           <!-- ADQUIRIENTE -->
                <ADQ_1>'. $adquiriente->tipo->codigo .'</ADQ_1>                             <!-- Tabla 20 Tipo de identificación - Tipos de Persona - codigo de cliente - OK -->
                <ADQ_2>'. $adquiriente->documento .'</ADQ_2>                                <!-- Numero de Documento de cliente - OK -->
                <ADQ_3>'. $adquiriente->tipo_doc->codigo .'</ADQ_3>                         <!-- Tabla 3 - Tipos de documentos de identidad - OK -->
                <ADQ_6>'. $adquiriente->nombre .'</ADQ_6>                                   <!-- Nombre del Cliente - RUT - OK -->
                <ADQ_7>'. $adquiriente->comercio .'</ADQ_7>                                 <!-- Nombre comercial del Cliente - RUT - OK -->
                <ADQ_10>'. $adquiriente->direccion .'</ADQ_10>                              <!-- dirección - OK -->
                <ADQ_11>'. $adquiriente->ciudad->departamento->codigo .'</ADQ_11>               <!-- Tabla 34 - Departamentos - codigo - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                <ADQ_13>'. $adquiriente->ciudad->ciudad .'</ADQ_13>                         <!-- Tabla 35 - Municipios - Nombre Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                <ADQ_14>190003</ADQ_14>                                                     <!-- Tabla 39 - Código Postal - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                <ADQ_15>CO</ADQ_15>                                                         <!-- Tabla 1 - Códigos de países - Alfa2 - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                <ADQ_19>'. $adquiriente->ciudad->departamento->departamento .'</ADQ_19>     <!-- Tabla 34 - Departamentos - nombre - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                <ADQ_21>Colombia</ADQ_21>                                                   <!-- Tabla 1 - Códigos de países - Nombre Común - Excel Simplificado Anexo - Tablas 2.1 - OK Cosntante -->
                <ADQ_22>'. $adquiriente->dv .'</ADQ_22>                                     <!-- DV Cliente - RUT - OK -->
                <ADQ_23>'. $adquiriente->ciudad->codigo .'</ADQ_23>                         <!-- Tabla 35 - Municipios - Código Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK --> 
                <TCR>                                   <!-- INFORMACION TRIBUTARIA ADQUIRIENTE -->
                    <TCR_1>'. $adquiriente->responsabilidad->codigo .'</TCR_1>              <!-- Tabla 36 Responsabilidades Fiscales - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                </TCR>
                <ILA>                                       <!-- INFORMACION LEGAL ADQUIRIENTE -->
                    <ILA_1>'. $adquiriente->nombre .'</ILA_1>                               <!-- Nombre del Cliente - RUT - OK -->
                    <ILA_2>'. $adquiriente->documento .'</ILA_2>                            <!-- Numero de Documento de cliente - OK -->
                    <ILA_3>'. $adquiriente->tipo_doc->codigo .'</ILA_3>                     <!-- Tabla 3 - Tipos de documentos de identidad - OK -->
                    <ILA_4>'. $adquiriente->dv .'</ILA_4>                                   <!-- DV Cliente - RUT - OK -->
                </ILA>
                <DFA>                                       <!-- INFORMACION FISCAL ADQUIRIENTE - OPCIONAL -->
                    <DFA_1>CO</DFA_1>                                                       <!-- Tabla 1 - Códigos de países - Alfa2 - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                    <DFA_2>'. $adquiriente->ciudad->departamento->codigo .'</DFA_2>             <!-- Tabla 34 - Departamentos - codigo - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                    <DFA_3>190003</DFA_3>                                                   <!-- Tabla 39 - Código Postal - Excel Simplificado Anexo - Tablas 2.1 - OK Constante Tabla 35 -->
                    <DFA_4>'. $adquiriente->ciudad->codigo .'</DFA_4>                       <!-- Tabla 35 - Municipios - Código Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK --> 
                    <DFA_5>Colombia</DFA_5>                                                 <!-- Tabla 1 - Códigos de países - Nombre Común - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                    <DFA_6>'. $adquiriente->ciudad->departamento->departamento .'</DFA_6>   <!-- Tabla 34 - Departamentos - nombre - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                    <DFA_7>'. $adquiriente->ciudad->ciudad .'</DFA_7>                       <!-- Tabla 35 - Municipios - Nombre Municipio - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                    <DFA_8>'. $adquiriente->direccion .'</DFA_8>                            <!-- dirección - OK -->
                </DFA>
                <ICR>                                     
                    <ICR_1>'. $adquiriente->matricula .'</ICR_1>                 <!-- INFORMACION CAMARA DE COMERCIO ADQUIRIENTE - OK -->
                </ICR>
                <CDA>                                       <!-- INFORMACION CONTACTO ADQUIRIENTE - OPCIONAL -->
                    <CDA_1>1</CDA_1>                                                        <!-- Tipo de Contacto - Excel Simplificado Anexo - OK Constante -->
                    <CDA_2>'. ($adquiriente->contacto->nombre   ?? '') .'</CDA_2>           <!-- Nombre de contacto, del cliente - OK -->
                    <CDA_3>'. ($adquiriente->contacto->celular  ?? '') .'</CDA_3>           <!-- Celular de contacto, del cliente - OK -->
                    <CDA_4>'. ($adquiriente->contacto->correo   ?? '') .'</CDA_4>           <!-- Correo de contacto, del cliente - OK -->
                </CDA>
                <GTA>                                       <!-- GRUPO DETALLES TRIBUTARIOS ADQUIRIENTE -->
                    <GTA_1>1</GTA_1>                                                        <!-- Tabla 11 - código - Impuestos registrados en la Factura Electrónica - OK -->
                    <GTA_2>IVA</GTA_2>                                                      <!-- Tabla 11 - nombre - Impuestos registrados en la Factura Electrónica - OK -->
                </GTA>
            </ADQ>
            
            <!-- TIPO DE CAMBIO - OPCIONAL -->

            <DRF>                                           <!-- RESOLUCIÓN DIAN -->
                <DRF_1>'. $emisor->resolucion->resolucion .'</DRF_1>                        <!-- Número de Resolución DIAN - OK -->
                <DRF_2>'. $emisor->resolucion->fecha_inicial .'</DRF_2>                     <!-- Fecha inicial Resolución - OK -->
                <DRF_3>'. $emisor->resolucion->fecha_final .'</DRF_3>                       <!-- Fecha final Resolución - OK -->
                <DRF_4>'. $emisor->resolucion->prefijo .'</DRF_4>                           <!-- Prefijo Resolución - OK -->
                <DRF_5>'. $emisor->resolucion->consecutivo_inicial .'</DRF_5>               <!-- Consecutivo Inicial - OK -->
                <DRF_6>'. $emisor->resolucion->consecutivo_final .'</DRF_6>                 <!-- Consecutivo Final - OK -->
            </DRF>
            <MEP>                                           <!-- MEDIOS DE PAGO -->
                <MEP_1>'. $factura->medio_pago->codigo .'</MEP_1>                           <!-- Tabla 5 - Códigos Medios de pago - Código / Code - Tablas 2.1 - OK -->
                <MEP_2>'. $factura->forma_pago->codigo .'</MEP_2>                           <!-- Tabla 26 - Formas de Pago - Código - Tablas 2.1 - OK -->
                <MEP_3>' .$createdAt->format('Y-m-d'). '</MEP_3>                            <!-- Fecha de Pago - OK CREATED AT -->
            </MEP>';
            
            $sumITE_5 = 0;
            $sumTOT_5  = 0;
            $totalTIMs = 0;
            $impuestos = [];
            
            foreach($factura->detalles as $key => $detalle) {
                
                $IIMs = '';
                $sumTIIs = 0;

                $sumITE_5 += $detalle->precio_venta * $detalle->cantidad;
                
                foreach( $detalle->producto->impuestos as $impuesto ) {
                    
                    if ( $impuesto->impuesto->tipo_impuesto == 'I' ) {
                        $total = 0;

                        if ( $impuesto->impuesto->tipo_tarifa == 'P' ) {
                            $total = $detalle->precio_venta * $detalle->cantidad * $impuesto->impuesto->tarifa / 100;
                        }

                        $sumTIIs += $total;
                        $totalTIMs += $sumTIIs;

                        $IIMs .= '<IIM>                     <!-- IMPUESTOS -->
                                    <IIM_1>'. $impuesto->impuesto->codigo .'</IIM_1>                        <!-- Tabla 44 - Impuestos registrados en la Factura Electrónica - Tablas 2.1 - OK -->
                                    <IIM_2>'. $total .'</IIM_2>                                             <!-- Total Impuesto -->
                                    <IIM_3>COP</IIM_3>                                                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                                    <IIM_4>'. ($detalle->precio_venta * $detalle->cantidad) .'</IIM_4>      <!-- Total Base -->
                                    <IIM_5>COP</IIM_5>                                                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                                    <IIM_6>'. $impuesto->impuesto->tarifa .'</IIM_6>                        <!-- Tabla 32 - Tarifas por Impuesto - TARIFA - Tablas 2.1 - OK -->
                                </IIM>';

                        $impuestos[$impuesto->impuesto->codigo] = [
                            'IMP_1' => $impuesto->impuesto->codigo,
                            'IMP_2' => $sumITE_5,
                            'IMP_3' => 'COP',
                            'IMP_4' => ($impuestos[$impuesto->impuesto->codigo]['IMP_4'] ?? 0) + $sumTIIs,
                            'IMP_5' => 'COP',
                            'IMP_6' => $impuesto->impuesto->tarifa,
                        ];
/*
                        $TIMs .= '<IMP>                                     <!-- IMPUESTOS -->
                                    <IMP_1>'. $impuesto->impuesto->codigo .'</IMP_1>                        <!-- Tabla 44 - Impuestos registrados en la Factura Electrónica - Tablas 2.1 - OK -->
                                    <IMP_2>'. $sumITE_5 .'</IMP_2>                                          <!-- Total Base -->
                                    <IMP_3>COP</IMP_3>                                                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                                    <IMP_4>'. $sumTIIs .'</IMP_4>                                           <!-- Total impuestos -->
                                    <IMP_5>COP</IMP_5>                                                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                                    <IMP_6>'. $impuesto->impuesto->tarifa .'</IMP_6>                        <!-- Tabla 32 - Tarifas por Impuesto - TARIFA - Tablas 2.1 - OK -->
                                </IMP>';
*/
                    }
                }
                
                $xml .= '
                    <ITE>                                   <!-- ITEMS DEL DOCUMENTO - ITERATIVO - OK Calculado -->
                        <ITE_1>' .($key + 1). '</ITE_1>                                     <!-- Número de Línea -->
                        <ITE_3>' .($detalle->cantidad). '</ITE_3>                           <!-- Cantidad total -->
                        <ITE_4>' .($detalle->producto->unidad_medida->codigo). '</ITE_4>    <!-- Tabla 12 - Unidades de medida - Código - Tablas 2.1 - OK -->
                        <ITE_5>' .($detalle->precio_venta * $detalle->cantidad). '</ITE_5>  <!-- Precio Unitario * cantidad -->
                        <ITE_6>COP</ITE_6>                                                  <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                        <ITE_7>' .($detalle->precio_venta). '</ITE_7>                       <!-- Precio Unitario - OK -->
                        <ITE_8>COP</ITE_8>                                                  <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                        <ITE_11>' .($detalle->producto->referencia). '</ITE_11>             <!-- Descripcion del producto -->
                        <ITE_20>COP</ITE_20>                                                <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                        <ITE_21>'. ($detalle->precio_venta * $detalle->cantidad) .'</ITE_21>        <!-- Valor Total  -->
                        <ITE_24>COP</ITE_24>                                                <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                        <ITE_27>' .($detalle->cantidad). '</ITE_27>                         <!-- Cantidad total -->
                        <ITE_28>' .($detalle->producto->unidad_medida->codigo). '</ITE_28>  <!-- Tabla 12 - Unidades de medida - Código - Tablas 2.1 - OK -->
                        <IAE>                              <!-- IDENTIFICACION DEL ARTICULO -->
                            <IAE_1>10</IAE_1>                       <!-- Tabla 31 - Productos - Código - Tablas 2.1 -->
                            <IAE_2>999</IAE_2>                      <!-- Tabla 31 - Productos - Código - Tablas 2.1 -->
                        </IAE>';
                    
                    $xml .='
                        <TII>                              <!-- TOTAL IMPUESTOS - OK Calculado -->
                            <TII_1>'. $sumTIIs .'</TII_1>                                   <!-- Cantidad total -->
                            <TII_2>COP</TII_2>                                              <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                            <TII_3>false</TII_3>                                            <!-- Es Impuesto Retenido? - OK -->
                            ' . $IIMs . '
                        </TII>
                    </ITE>';


                    $sumTOT_5 += ($detalle->precio_venta * $detalle->cantidad) ;// + $totalTIMs;
            }


            $TIMs = '';
            foreach( $impuestos as $key => $impuesto ) {
                $TIMs .= '<IMP>                                     <!-- IMPUESTOS -->
                        <IMP_1>'. $impuesto['IMP_1'] .'</IMP_1>                        <!-- Tabla 44 - Impuestos registrados en la Factura Electrónica - Tablas 2.1 - OK -->
                        <IMP_2>'. $impuesto['IMP_2'] .'</IMP_2>                        <!-- Total Base -->
                        <IMP_3>'. $impuesto['IMP_3'] .'</IMP_3>                        <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                        <IMP_4>'. $impuesto['IMP_4'] .'</IMP_4>                        <!-- Total impuestos -->
                        <IMP_5>'. $impuesto['IMP_5'] .'</IMP_5>                        <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                        <IMP_6>'. $impuesto['IMP_6'] .'</IMP_6>                        <!-- Tabla 32 - Tarifas por Impuesto - TARIFA - Tablas 2.1 - OK -->
                    </IMP>';
            }
            
            $xml .= '
                <TOT>                                       <!-- TOTALES -->
                    <TOT_1>'. $sumITE_5 .'</TOT_1>                                          <!-- Total Bruto -->
                    <TOT_2>COP</TOT_2>                                                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                    <TOT_3>'. $sumITE_5 .'</TOT_3>                                          <!-- Total Base -->
                    <TOT_4>COP</TOT_4>                                                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                    <TOT_5>'. ($sumTOT_5 + $totalTIMs) .'</TOT_5>                                          <!--Gran Total -->
                    <TOT_6>COP</TOT_6>                                                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                    <TOT_7>'. ($sumTOT_5 + $totalTIMs) .'</TOT_7>                                          <!-- Total Brutos + impuestos -->
                    <TOT_8>COP</TOT_8>                                                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                </TOT>
                <TIM>                                       <!-- TOTAL IMPUESTOS -->
                    <TIM_1>false</TIM_1>                                                    <!-- Es Impuesto Retenido? - OK -->
                    <TIM_2>'. $totalTIMs .'</TIM_2>                                         <!-- Total impuestos -->
                    <TIM_3>COP</TIM_3>                                                      <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                    '. $TIMs .'
                </TIM>
            </FACTURA>';

            $credenciales = Credenciales::where('estado', 'A')->first();

            $result = $client->__soapCall('FtechAction.uploadInvoiceFile', [
                'username' => $credenciales->username,
                'password' => $credenciales->password,
                'xmlBase64' => base64_encode($xml),
            ]);

            if ( $result->code == '201') {
                Consecutivos::updateOrCreate(
                    [
                        'id' => $consecutivo->id ?? null
                    ], [
                        'consecutivo' => ($consecutivo->consecutivo ?? 1) + 1
                    ]
                );

                $factura->folio = $consecutivo->consecutivo ?? 1;
                $factura->prefijo = $emisor->resolucion->prefijo;
                $factura->transaccionID = $result->transaccionID;
                $factura->estado = 'C';
                $factura->save();

            } else {
                $result->data = [
                    'emisor' => $emisor,
                    'adquiriente' => $adquiriente,
                    'consecutivo' => $consecutivo,
                    'factura' => $factura,
                    'factura No' => $emisor->resolucion->prefijo . ($consecutivo->consecutivo ?? 1)
                ];
                $result->xml = $xml;
                $result->base64 = base64_encode($xml);
                $result->errors = explode('"', $result->error);
            }

            return $result;
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    // Paso 2. documentStatusFile
    public function status( $id )
    {
        try {
            // $wsdlUrl = 'https://webservice.facturatech.co/v2/BETA/WSV2DEMO.asmx?WSDL';
            $wsdlUrl = 'https://ws.facturatech.co/v2/demo/index.php?wsdl';

            $soapClientOptions = [
                'encoding' => 'UTF-8',
                'soap_version' => 'SOAP_1_2',
                'trace' => 1,
                'exceptions' => 1,
                'connection_timeout' => 100,
                'soap.wsdl_cache_enabled' => '0',
            ];

            $factura = Facturas::find($id);

            $client = new \SoapClient($wsdlUrl, $soapClientOptions);

            $credenciales = Credenciales::where('estado', 'A')->first();

            $result = $client->__soapCall('FtechAction.documentStatusFile', [
                'username' => $credenciales->username, // 'MACO02062024',
                'password' => $credenciales->password, // '2a4d4a72f5aacf82e517cad6943fd3891157a52d8ed5a6fddedbbd31632035e8',
                'transaccionID' =>  $factura->transaccionID,
            ]);

            return $result;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    // Paso 2. downloadPDFFile
    public function download( $id )
    {
        try {

            $status = $this->status( $id );
            $result = '';

            if ( $status->code == '201') {

                // $wsdlUrl = 'https://webservice.facturatech.co/v2/BETA/WSV2DEMO.asmx?WSDL';
                $wsdlUrl = 'https://ws.facturatech.co/v2/demo/index.php?wsdl';
    
                $soapClientOptions = [
                    'encoding' => 'UTF-8',
                    'soap_version' => 'SOAP_1_2',
                    'trace' => 1,
                    'exceptions' => 1,
                    'connection_timeout' => 1000,
                    'soap.wsdl_cache_enabled' => '0',
                ];
    
                $factura = Facturas::find($id);
                
                $client = new \SoapClient($wsdlUrl, $soapClientOptions);
                
                $credenciales = Credenciales::where('estado', 'A')->first();

                $result = $client->__soapCall('FtechAction.downloadPDFFile', [
                    'username' => $credenciales->username,
                    'password' => $credenciales->password,
                    'prefijo' => $factura->prefijo,
                    'folio' => $factura->folio,
                ]);
    
                // Decode pdf content
                $pdf_decoded = base64_decode($result->resourceData);
                $pdf = fopen($factura->prefijo . $factura->folio . '.pdf', 'w');
                fwrite($pdf, $pdf_decoded);
                fclose($pdf);
    
                if( $result->code == '404' ) {
                    $result->folio = $factura->prefijo . $factura->folio;
                }
            } else {
                $result = $status;
            }

            return $result;
        } catch (Exception $ex) {
            return $ex;
        }
    }


    function qr( $id ) {
        try {

            $status = $this->status( $id );
            $result = '';

            if ( $status->code == '201') {

                // $wsdlUrl = 'https://webservice.facturatech.co/v2/BETA/WSV2DEMO.asmx?WSDL';
                $wsdlUrl = 'https://ws.facturatech.co/v2/demo/index.php?wsdl';
    
                $soapClientOptions = [
                    'encoding' => 'UTF-8',
                    'soap_version' => 'SOAP_1_2',
                    'trace' => 1,
                    'exceptions' => 1,
                    'connection_timeout' => 1000,
                    'soap.wsdl_cache_enabled' => '0',
                ];
    
                $factura = Facturas::find($id);
                
                $client = new \SoapClient($wsdlUrl, $soapClientOptions);
                
                $credenciales = Credenciales::where('estado', 'A')->first();

                $result = $client->__soapCall('FtechAction.getQRFile', [
                    'username' => $credenciales->username,
                    'password' => $credenciales->password,
                    'prefijo' => $factura->prefijo,
                    'folio' => $factura->folio,
                ]);
    
                if( $result->code == '404' ) {
                    $result->folio = $factura->prefijo . $factura->folio;
                }
            } else {
                $result = $status;
            }

            return $result;
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
