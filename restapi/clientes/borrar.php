<?php 
// Headers necesarios. 
 
// Permitimos que el archivo pueda ser leído por cualquier usuario. 
header("Access-Control-Allow-Origin: *"); 
 
// Indicamos que el resultado se devolverá en un JSON y codificado en UTF-8 
header("Content-Type: application/json; charset=UTF-8"); 
 
// Recibimos los datos por POST. 
header("Access-Control-Allow-Methods: GET"); 
   
// Incluimos la gestión de la tabla clientes. 
include_once('../bd/clientes.php'); 
 
// JSON con el mensaje de respuesta. 
$json = array(); 
 
// Si no nos envían el cliente a borrar por DELETE, error. 
if ($_SERVER['REQUEST_METHOD'] != "DELETE") 
{ 
    // Código de respuesta - Method Not Alloweb 
    http_response_code(405);     
 
    $json['message'] = 'Sólo se permite el método DELETE.'; 
} 
else
    { 
    // Verificamos que están los datos. 
    if (isset($_GET['id'])) 
    { 
        // Creamos el objeto para borrar el cliente. 
        $cliente = new ClientesBD(); 
 
        // Le indicamos el cliente... 
        $cliente->id = $_GET['id']; 
 
        // y borramos 
        $filas = $cliente->Borrar(); 
 
        // Si no se ha podido borrar. 
        if ($filas == -1 || $clientes->Error()) 
        { 
            // Código de respuesta - 400 Bad Request 
            http_response_code(400); 
 
            $json['message'] = $clientes->GetError(); 
        } 
        // No se ha borrado nada. 
        elseif ($filas == 0) 
        { 
            // Código de respuesta - 400 Bad Request 
            http_response_code(400); 
 
            $json['message'] = 'Cliente no borrado.'; 
        } 
        else 
        { 
            // Código de respuesta - 200 OK 
            http_response_code(200); 
 
            $json['message'] = 'Cliente borrado.'; 
        } 
    } 
    else 
    { 
        // Código de respuesta - 400 Bad Resquest 
        http_response_code(400); 
 
        $json['message'] = 'No se indica el cliente a borrar.'; 
    }
} 
// Devolvemos el JSON 
echo json_encode($json); 
?> 