<?php
include('lib/nusoap.php');

$server = new nusoap_server();
$server->configureWSDL('Api DGT', 'urn:apidgt_ws');

// Parametros de entrada
$server->wsdl->addComplexType(  'datos_vehiculo_entrada', 
                                'complexType', 
                                'struct', 
                                'all', 
                                '',
                                array('user'   => array('user' => 'user','type' => 'xsd:string'),
                                      'pass'    => array('pass' => 'pass','type' => 'xsd:string'),
                                      'matricula' => array('matricula' => 'matricula','type' => 'xsd:string'),
                                      'manipulador'  => array('manipulador' => 'manipulador','type' => 'xsd:string'))
);
// Parametros de Salida
$server->wsdl->addComplexType(  'datos_vehiculo_salida', 
                                'complexType', 
                                'struct', 
                                'all', 
                                '',
                                array('mensaje'   => array('name' => 'mensaje','type' => 'xsd:string'))
);

$server->register(  'datos_vehiculo', // nombre del metodo o funcion
                    array('datos_vehiculo_entrada' => 'tns:datos_vehiculo_entrada'), // parametros de entrada
                    array('return' => 'tns:datos_vehiculo_salida'), // parametros de salida
                    'urn:apidgt_ws', // namespace
                    'urn:dgtwsdl#datos_vehiculo', // soapaction debe ir asociado al nombre del metodo
                    'rpc', // style
                    'encoded', // use
                    'La siguiente funcion recibe los parametros de la matricula y envía los datos resultantes' // documentation
);

function datos_vehiculo($datos) {

    // Fichero de configuracion local
    require_once('config.php');
    $mysqli = new mysqli($_conf['bda_host'], $_conf['bda_user'], $_conf['bda_password'], $_conf['bda']);

    /* comprobar la conexión */
    if ($mysqli->connect_errno) {
        printf("Falló la conexión: %s\n", $mysqli->connect_error);
        exit();
    }
	
	
    /* Consulta para obtener los datos del usuario logado */
	$reg_user=$datos['user'];
	$reg_pass=$datos['pass'];
	$matricula=$datos['matricula'];
	
	//composición del mensaje de respuesta erroneo
    $msg = 'No tiene acceso a esta informacion, este usuario no existe: ' . $reg_user . '.';
	
	$query = "SELECT usu_name FROM api_users WHERE usu_name='".$reg_user."' AND usu_pass='".$reg_pass."'";
	$DatosUser = $mysqli->query($query);
    $DatosUser ? $DatosValUser = 1 :  $DatosValUser = 0;
    if( $DatosValUser == 1 ){
		
		while($dconex = mysqli_fetch_array($DatosUser)) {
			
			/*
            //Configuración de la petición a la DGT
            $client = new nusoap_client('http://pr-apls-prep.dgt.es:8080/WS_ATEX5/services/ATEX?wsdl','wsdl');
            $err = $client->getError();
            if ($err) {	echo 'Error en Constructor' . $err ; }

            //Parámetros para la comunicación con la DGT
            $idUsuario = '52661833K'; // informar el id de usuario
            $idOrganismoResponsable = 'B90235953'; // informar el organismo
            $idResponsable = '52661833K'; // informar el Responsable
            $version = '5'; // informar de la versión
            $matricula = $datos['matricula']; //  informar el número de matricula
			$manipulador = $datos['manipulador']; //  informar el número de matricula
			$pet_url='http://pr-apls-prep.dgt.es:8080/WS_ATEX5/services/ATEX?wsdl'; // wsdl dgt
			$pet_soap='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.atex.consulta.vehiculos.servicios.trafico.es">
                        <soapenv:Header/>
                        <soapenv:Body>
                           <web:SolicitudConsultaVehiculoAtex>
                              <web:idUsuario>'.$idUsuario.'</web:idUsuario>
                              <!--Optional:-->
                              <web:idOrganismoResponsable>'.$idOrganismoResponsable.'</web:idOrganismoResponsable>
                              <web:idResponsable>'.$idResponsable.'</web:idResponsable>
                              <web:version>'.$version.'</web:version>
                              <!--Optional:-->
                              <!--<web:tasa>?</web:tasa> -->
                              <web:CriteriosConsultaVehiculo>
                                 <!--Optional:-->
                                 <web:matricula>'.$matricula.'</web:matricula>
                                 <!--Optional:-->
                                 <!--<web:bastidor>?</web:bastidor>-->
                                 <!--Optional:-->
                                 <!--<web:nive>?</web:nive>-->
                              </web:CriteriosConsultaVehiculo>
                           </web:SolicitudConsultaVehiculoAtex>
                        </soapenv:Body>
                     </soapenv:Envelope>';
			 */
			 
			 $url_destino="http://mdsdgt.es/WsDGT-1/envio/xml/".$matricula;
			 $valor = file_get_contents($url_destino);

            //Guardado de la petición a la DGT
            $query = "INSERT INTO api_peticiones (pet_usu, pet_manipula, pet_org, pet_respons, pet_version, pet_matr, pet_date, pet_url, pet_res, pet_soap) 
            VALUES ('".$idUsuario."', '".$manipulador."', '".$idOrganismoResponsable."', '".$idResponsable."', '".$version."', '".$matricula."', NOW(), '".$pet_url."', 0, '".$pet_soap."')";
            if ($mysqli->query($query) === TRUE) { 
				
						
                       //composición del mensaje de respuesta
                       $msg = 'Bienvenido, ' . $reg_user . '.  validada la matricula: ' . $matricula . ', manipulador: ' . $manipulador . '.';    
					   $msg = $valor . ' ' . 'Bienvenido, ' . $reg_user . '.  validada la matricula: ' . $matricula . ', manipulador: ' . $manipulador . '.';   
            }
		}
		
	}
	$DatosUser->close();

    return array('mensaje' => $msg);
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);