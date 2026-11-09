<?php

include("seguridad.php");

if(
$_SESSION['id_rol'] != 1
&&
$_SESSION['id_rol'] != 2
){

    die("Acceso denegado");

}

?>
