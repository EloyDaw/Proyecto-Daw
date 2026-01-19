<?php 
require_once("../config.php"); 
 
class BD 
{ 
    private $con   = null; // Conexión a la BBDD. 
    private $error = '';   // Mensaje de error. 
 
    function __construct() 
    { 
        $this->error = ''; 
 
        try 
        { 
            // Creamos la conexión. 
            $this->con = new PDO('mysql:host=' . SERVIDOR .  
                                 ';dbname=' . BASEDATOS .  
                                 ';charset=utf8',  
                                 USUARIO,  
                                 CONTRASENA); 
 
            // Si se logra crear la conexión. 
            if ($this->con)  
            { 
                // Ponemos los atributos para gestionar los errores con excepciones. 
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                 
                // El juego de caracteres será utf-8 
                $this->con->exec('SET CHARACTER SET utf8'); 
            } 
        } 
        catch (PDOException $e) 
        { 
            $this->error = $e->getMessage(); 
        } 
    } 
 
    function __destruct() 
    {
            // Cerramos la conexión a la BBDD. 
        $this->con = null; 
    } 
 
    protected function _consultar($query)  
    { 
        $this->error = ''; 
 
        $filas = null;  
 
        try 
        { 
            // Preparamos la consulta... 
            $stmt = $this->con->prepare($query); 
 
            // y la ejecutamos. 
            $stmt->execute(); 
 
            // Si nos devuelve alguna fila... 
            if ($stmt->rowCount() > 0) 
            { 
                // Creamos el array... 
                $filas = array(); 
  
                // y lo rellenamos con los datos de la consulta.  
                while ($registro = $stmt->fetchObject())     
                    $filas[] = $registro;                    
            } 
        } 
        catch (PDOException $e) 
        { 
            $this->error = $e->getMessage(); 
        } 
 
        // Devolvemos las filas obtenidas de la consulta. 
        return $filas;  
    } 
 
    protected function _ejecutar($query) 
    { 
        $this->error = ''; 
 
        $filas = 0; 
            try 
        { 
            // Ejecutamos la sentencia y guardamos el número de filas afectadas. 
            $filas = $this->con->exec($query); 
        } 
        catch (PDOException $e) 
        { 
            $this->error = $e->getMessage(); 
 
  $filas = -1; 
        } 
 
        // Devolvemos el número de filas afectadas. 
        return $filas; 
    } 
 
    protected function _ultimoId() 
    { 
        // Devolvemos el id de la última fila insertada. 
        return $this->con->lastInsertId(); 
    } 
 
    public function GetError() 
    { 
        // Obtenemos el mensaje del error, si este se produce. 
        return $this->error; 
    } 
 
    public function Error() 
    { 
        // Indicamos si ha habido algún error. 
        return ($this->error != ''); 
    } 
} 
?>