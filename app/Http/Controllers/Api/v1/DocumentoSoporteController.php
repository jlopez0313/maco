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


class DocumentoSoporteController extends Controller
{
    protected $wsdlUrl;
    protected $soapClientOptions;

    public function __construct() {
        $this->wsdlUrl = 'https://ws.facturatech.co/v2/pro/index.php?wsdl';

        $this->soapClientOptions = [
            'encoding' => 'UTF-8',
            'soap_version' => 'SOAP_1_2',
            'trace' => 1,
            'exceptions' => 1,
            'connection_timeout' => 100,
            'soap.wsdl_cache_enabled' => '0',
        ];
    }

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
            $wsdlUrl = 'https://ws.facturatech.co/v2/pro/index.php?wsdl';

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
           
            $client = new \SoapClient($this->wsdlUrl, $this->soapClientOptions);
    
    /*
                <?xml version="1.0"?>
                <DOCUMENTO_SOPORTE>
                    <ENC>
                        <ENC_1>DS</ENC_1>
                        <ENC_2>901143311</ENC_2>
                        <ENC_4>UBL 2.1</ENC_4>
                        <ENC_5>DIAN 2.1</ENC_5>
                        <ENC_6>DS14861</ENC_6>
                        <ENC_7>2022-08-07</ENC_7>
                        <ENC_8>21:01:53</ENC_8>
                        <ENC_9>95</ENC_9>
                        <ENC_10>USD</ENC_10>
                        <ENC_15>2</ENC_15>
                        <ENC_20>2</ENC_20>
                        <ENC_21>11</ENC_21>
                    </ENC>
                    <PRO>
                        <PRO_1>1</PRO_1>
                        <PRO_2>564897012</PRO_2>
                        <PRO_3>50</PRO_3>
                        <PRO_6>Addison Olson</PRO_6>
                        <PRO_10>325 Elsie Drive</PRO_10>
                        <PRO_13>Notificaci&#xF3;n</PRO_13>
                        <PRO_15>US</PRO_15>
                        <PRO_19>West Virginia</PRO_19>
                        <PRO_21>United States</PRO_21>
                        <PRO_22>4</PRO_22>
                        <TAC>
                            <TAC_1>R-99-PN</TAC_1>
                        </TAC>
                        <GTE>
                            <GTE_1>01</GTE_1>
                            <GTE_2>IVA</GTE_2>
                        </GTE>
                    </PRO>
                    <ADQ>
                        <ADQ_1>1</ADQ_1>
                        <ADQ_2>901143311</ADQ_2>
                        <ADQ_3>31</ADQ_3>
                        <ADQ_6>Ftech Solutions SAS</ADQ_6>
                        <ADQ_22>8</ADQ_22>
                        <TCR>
                            <TCR_1>O-13</TCR_1>
                        </TCR>
                        <GTA>
                            <GTA_1>01</GTA_1>
                            <GTA_2>IVA</GTA_2>
                        </GTA>
                    </ADQ>
                    <TOT>
                        <TOT_1>1200.00</TOT_1>
                        <TOT_2>USD</TOT_2>
                        <TOT_3>0.00</TOT_3>
                        <TOT_4>USD</TOT_4>
                        <TOT_5>1200.00</TOT_5>
                        <TOT_6>USD</TOT_6>
                        <TOT_7>1200.00</TOT_7>
                        <TOT_8>USD</TOT_8>
                    </TOT>
                    <TIM>
                        <TIM_1>false</TIM_1>
                        <TIM_2>0</TIM_2>
                        <TIM_3>USD</TIM_3>
                        <IMP>
                            <IMP_1>01</IMP_1>
                            <IMP_2>1066.05</IMP_2>
                            <IMP_3>USD</IMP_3>
                            <IMP_4>0.00</IMP_4>
                            <IMP_5>USD</IMP_5>
                            <IMP_6>0</IMP_6>
                        </IMP>
                    </TIM>
                    <DRF>
                        <DRF_1>18764027520944</DRF_1>
                        <DRF_2>2022-06-01</DRF_2>
                        <DRF_3>2030-06-30</DRF_3>
                        <DRF_4>DS</DRF_4>
                        <DRF_5>14801</DRF_5>
                        <DRF_6>14900</DRF_6>
                    </DRF>
                    <MEP>
                        <MEP_1>10</MEP_1>
                        <MEP_2>1</MEP_2>
                        <MEP_3>2022-08-08</MEP_3>
                    </MEP>
                    <ITE>
                        <ITE_1>1</ITE_1>
                        <ITE_3>1.0</ITE_3>
                        <ITE_4>94</ITE_4>
                        <ITE_5>500.00</ITE_5>
                        <ITE_6>USD</ITE_6>
                        <ITE_7>500.00</ITE_7>
                        <ITE_8>USD</ITE_8>
                        <ITE_11>[06255302]-TERAPIAS FISICAS CAPITA PTO TEJADA</ITE_11>
                        <ITE_27>1</ITE_27>
                        <ITE_28>94</ITE_28>
                        <IAE>
                            <IAE_1>1551</IAE_1>
                            <IAE_2>999</IAE_2>
                        </IAE>
                    </ITE>
                    <ITE>
                        <ITE_1>2</ITE_1>
                        <ITE_3>1.0</ITE_3>
                        <ITE_4>94</ITE_4>
                        <ITE_5>700.00</ITE_5>
                        <ITE_6>USD</ITE_6>
                        <ITE_7>700.00</ITE_7>
                        <ITE_8>USD</ITE_8>
                        <ITE_11>[61251047]-TERAPIA FISICA SALUD OCUPACIONAL PTO</ITE_11>
                        <ITE_27>1</ITE_27>
                        <ITE_28>94</ITE_28>
                        <IAE>
                            <IAE_1>1553</IAE_1>
                            <IAE_2>999</IAE_2>
                        </IAE>
                    </ITE>
                </DOCUMENTO_SOPORTE>
                ';
    */

            $gasto = Gastos::with('detalles.producto.unidad_medida', 'detalles.producto.medida', 'detalles.producto.impuestos')->find($id);
            $createdAt = \Carbon\Carbon::parse($gasto->created_at);

            $consecutivo = Consecutivos::first();

            $adquiriente = Empresas::with('tipo', 'responsabilidad', 'tipo_doc', 'ciudad.departamento', 'contacto', 'resolucion')
            ->first();

            $proveedor = Clientes::with('tipo', 'responsabilidad', 'tipo_doc', 'ciudad.departamento', 'contacto')
            ->find($gasto->clientes_id);

            // return [$emisor, $adquiriente, $consecutivo, $emisor->resolucion->prefijo . ($consecutivo->consecutivo ?? 1)];

            $fechaHoy = \Carbon\Carbon::now();

            $xml = '<?xml version="1.0" encoding="UTF-8"?> <!-- FACTURA DE EXPORTACION V1.9 -->
            <DOCUMENTO_SOPORTE>
            <ENC>                                           <!-- ENCABEZADO -->
                <ENC_1>DS</ENC_1>                                                           <!-- Tipo de Documento - Excel Simplificado Anexo - Estandar Simplificado - OK Constante -->
                <ENC_2>'.$adquiriente->documento.'</ENC_2>                                       <!-- NIT Emisor - OK - para Pruebas 901143311 --> 
                <ENC_4>UBL 2.1</ENC_4>                                                      <!-- Constante - OK -->
                <ENC_5>DIAN 2.1</ENC_5>                                                     <!-- Constante - OK -->
                
                <ENC_6>'. $adquiriente->autorizacion->prefijo . ($consecutivo->consecutivo ?? 1) .'</ENC_6>                                              <!-- Prefijo y numero de factura - OK -->
                
                <ENC_7>'.$fechaHoy->format('Y-m-d').'</ENC_7>                               <!-- Fecha Hoy -->
                <ENC_8>'.$fechaHoy->format('H:i:s').'</ENC_8>                               <!-- Hora Hoy -->
                <ENC_9>95</ENC_9>                                                           <!-- Tipo de Factura - Excel Simplificado Anexo - Estandar Simplificado - OK Constante -->
                <ENC_10>COP</ENC_10>                                                        <!-- Tabla 13 - Monedas - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                <ENC_15>'. count($gasto->detalles) .'</ENC_15>                            <!-- Número de lineas en el detalle - OK Calculado -->
                <ENC_20>2</ENC_20>                                                          <!-- Tabla 28 - Ambiente Destino Del Documento - Excel Simplificado Anexo - Tablas 2.1 - OK Constante -->
                <ENC_21>11</ENC_21>                                                         <!-- Tabla 38 - Tipo de operación - Tablas 2.1 - OK Constante -->
            </ENC>
            <PRO>
                <PRO_1>1</PRO_1>
                <PRO_2>564897012</PRO_2>
                <PRO_3>50</PRO_3>
                <PRO_6>Addison Olson</PRO_6>
                <PRO_10>325 Elsie Drive</PRO_10>
                <PRO_13>Notificaci&#xF3;n</PRO_13>
                <PRO_15>US</PRO_15>
                <PRO_19>West Virginia</PRO_19>
                <PRO_21>United States</PRO_21>
                <PRO_22>4</PRO_22>
                <TAC>
                    <TAC_1>R-99-PN</TAC_1>
                </TAC>
                <GTE>
                    <GTE_1>01</GTE_1>
                    <GTE_2>IVA</GTE_2>
                </GTE>
            </PRO>
            <ADQ>                                           <!-- ADQUIRIENTE -->
                <ADQ_1>'. $adquiriente->tipo->codigo .'</ADQ_1>                             <!-- Tabla 20 Tipo de identificación - Tipos de Persona - codigo de cliente - OK -->
                <ADQ_2>'. $adquiriente->documento .'</ADQ_2>                                <!-- Numero de Documento de cliente - OK -->
                <ADQ_3>'. $adquiriente->tipo_doc->codigo .'</ADQ_3>                         <!-- Tabla 3 - Tipos de documentos de identidad - OK -->
                <ADQ_6>'. $adquiriente->nombre .'</ADQ_6>                                   <!-- Nombre del Cliente - RUT - OK -->
                <ADQ_22>'. $adquiriente->dv .'</ADQ_22>                                     <!-- DV Cliente - RUT - OK -->
                <TCR>                                   <!-- INFORMACION TRIBUTARIA ADQUIRIENTE -->
                    <TCR_1>'. $adquiriente->responsabilidad->codigo .'</TCR_1>              <!-- Tabla 36 Responsabilidades Fiscales - Excel Simplificado Anexo - Tablas 2.1 - OK -->
                </TCR>
                <GTA>                                       <!-- GRUPO DETALLES TRIBUTARIOS ADQUIRIENTE -->
                    <GTA_1>1</GTA_1>                                                        <!-- Tabla 11 - código - Impuestos registrados en la Factura Electrónica - OK -->
                    <GTA_2>IVA</GTA_2>                                                      <!-- Tabla 11 - nombre - Impuestos registrados en la Factura Electrónica - OK -->
                </GTA>
            </ADQ>
            
            <!-- TIPO DE CAMBIO - OPCIONAL -->
            <DRF>                                           <!-- RESOLUCIÓN DIAN -->
                <DRF_1>'. $adquiriente->autorizacion->resolucion .'</DRF_1>                        <!-- Número de Resolución DIAN - OK -->
                <DRF_2>'. $adquiriente->autorizacion->fecha_inicial .'</DRF_2>                     <!-- Fecha inicial Resolución - OK -->
                <DRF_3>'. $adquiriente->autorizacion->fecha_final .'</DRF_3>                       <!-- Fecha final Resolución - OK -->
                <DRF_4>'. $adquiriente->autorizacion->prefijo .'</DRF_4>                           <!-- Prefijo Resolución - OK -->
                <DRF_5>'. $adquiriente->autorizacion->consecutivo_inicial .'</DRF_5>               <!-- Consecutivo Inicial - OK -->
                <DRF_6>'. $adquiriente->autorizacion->consecutivo_final .'</DRF_6>                 <!-- Consecutivo Final - OK -->
            </DRF>
            <MEP>                                           <!-- MEDIOS DE PAGO -->
                <MEP_1>'. $gasto->medio_pago->codigo .'</MEP_1>                           <!-- Tabla 5 - Códigos Medios de pago - Código / Code - Tablas 2.1 - OK -->
                <MEP_2>'. $gasto->forma_pago->codigo .'</MEP_2>                           <!-- Tabla 26 - Formas de Pago - Código - Tablas 2.1 - OK -->
                <MEP_3>' .$createdAt->format('Y-m-d'). '</MEP_3>                            <!-- Fecha de Pago - OK CREATED AT -->
            </MEP>';
            
            $sumITE_5 = 0;
            $sumTOT_5  = 0;
            $totalTIMs = 0;
            $impuestos = [];
            
            foreach($gasto->detalles as $key => $detalle) {
                
                $IIMs = '';
                $sumTIIs = 0;

                $sumITE_5 += $detalle->precio_venta * $detalle->cantidad;
                
                foreach( $detalle->producto->impuestos as $impuesto ) {
                    
                    if ( $impuesto->impuesto->tipo_impuesto == 'R' ) {
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
            </DOCUMENTO_SOPORTE>';

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
                        'consecutivo' => ($consecutivo->consecutivo ?? 1) + 1,
                        'from' => 'c',
                    ]
                );

                $gasto->folio = $consecutivo->consecutivo ?? 1;
                $gasto->prefijo = $emisor->resolucion->prefijo;
                $gasto->transaccionID = $result->transaccionID;
                $gasto->estado = 'C';
                $gasto->save();

            } else {
                $result->data = [
                    'adquiriente' => $adquiriente,
                    'consecutivo' => $consecutivo,
                    'factura compra' => $gasto,
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

            $gasto = Gastos::find($id);

            $client = new \SoapClient($this->wsdlUrl, $this->soapClientOptions);

            $credenciales = Credenciales::where('estado', 'A')->first();

            $result = $client->__soapCall('FtechAction.documentStatusFile', [
                'username' => $credenciales->username, // 'MACO02062024',
                'password' => $credenciales->password, // '2a4d4a72f5aacf82e517cad6943fd3891157a52d8ed5a6fddedbbd31632035e8',
                'transaccionID' =>  $gasto->transaccionID,
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

                $gasto = Gastos::find($id);
                
                $client = new \SoapClient($this->wsdlUrl, $this->soapClientOptions);
                
                $credenciales = Credenciales::where('estado', 'A')->first();

                $result = $client->__soapCall('FtechAction.downloadPDFFile', [
                    'username' => $credenciales->username,
                    'password' => $credenciales->password,
                    'prefijo' => $gasto->prefijo,
                    'folio' => $gasto->folio,
                ]);
    
                // Decode pdf content
                $pdf_decoded = base64_decode($result->resourceData);
                $pdf = fopen($gasto->prefijo . $gasto->folio . '.pdf', 'w');
                fwrite($pdf, $pdf_decoded);
                fclose($pdf);
    
                if( $result->code == '404' ) {
                    $result->folio = $gasto->prefijo . $gasto->folio;
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
                
                $gasto = Gastos::find($id);
                
                $client = new \SoapClient($this->wsdlUrl, $this->soapClientOptions);
                
                $credenciales = Credenciales::where('estado', 'A')->first();

                $result = $client->__soapCall('FtechAction.getQRFile', [
                    'username' => $credenciales->username,
                    'password' => $credenciales->password,
                    'prefijo' => $gasto->prefijo,
                    'folio' => $gasto->folio,
                ]);
    
                if( $result->code == '404' ) {
                    $result->folio = $gasto->prefijo . $gasto->folio;
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
