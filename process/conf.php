<?php
error_reporting(E_ALL & E_STRICT);
ini_set("display_errors", "1");
ini_set("log_errors", "0");
ini_set("error_log", "./");
date_default_timezone_set("America/Bogota");

//Mail Settings
define("HOST_MAIL","smtp.gmail.com");
define("USER_MAIL","usuario");
define("PASS_MAIL","clave");
define("PROTOCOL_MAIL","tls");
define("PORT_MAIL","587");

//Database
define("DB_DB","hotspot"); //Define nombre base de datos
define("DB_USER","root"); //Define usuario de base de datos
define("DB_PASS",""); //Define contraseña base de datos
define("DB_HOST","127.0.0.1"); //Define host base de datos
define("DB_PORT","3306"); //Define puerto base de datos
define("DB_DRIVER","mysql"); //Define driver de base de datos

//Variable de conexión
$conn_sql = new PDO(DB_DRIVER.":host=".DB_HOST.";dbname=".DB_DB.";port:".DB_PORT, DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

//Funciones generales
function sanarString($var){
	$var = filter_var(trim($var),FILTER_SANITIZE_STRING);
	return $var;
}

?>