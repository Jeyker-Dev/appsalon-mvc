<?php 

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index( Router $router ) {
        session_start();

        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);

        if( !checkdate( $fechas[1], $fechas[2], $fechas[0]) ) {
            header('Location: /404');
        }

        // Query Database
        $consulta = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) as cliente,
        usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio FROM citas
        LEFT OUTER JOIN usuarios ON citas.usuarioid = usuarios.id
        LEFT OUTER JOIN citas_servicios ON citas_servicios.citas_id = citas.id
        LEFT OUTER JOIN servicios ON servicios.id = citas_servicios.servicios_id ";
        $consulta.= "WHERE citas.fecha = '{$fecha}' ";

        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas, 
            'fecha' => $fecha
        ]);
    }
}