<?php

include('lib/nusoap.php');

//Parámetros
$idUsuario = '52661833K'; // informar el id de usuario
$idOrganismoResponsable = 'B90235953'; // informar el organismo
$idResponsable = '52661833K'; // informar el Responsable
$version = '5'; // informar de la versión
$matricula = '2723ggt'; //  informar el número de matricula

$parameters = array('idUsuario'=>$idUsuario, 'idOrganismoResponsable' => $idOrganismoResponsable, 'idResponsable' => $idResponsable, 'version' => $version, 'CriteriosConsultaVehiculo' => array('matricula' => $matricula));

$wsdl = "http://pr-apls-prep.dgt.es:8080/WS_ATEX5/services/ATEX?wsdl";
$localCert = "mds.pem";
$clientOptions = array('local_cert' => $localCert, 'passphrase' => 'probar',
                       'soap_version' => SOAP_1_1, 'encoding' => 'UTF-8',
                       'compression' => (SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP),
                       'location' => 'http://pr-apls-prep.dgt.es:8080/WS_ATEX5/services/ATEX');

$client = new nusoap_client($wsdl, $clientOptions);
$result = $client->call('consultaATEXVehiculo', $parameters);
print_r($result);

