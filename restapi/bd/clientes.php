<?php
require_once("bd.php"); 
 
class ClientesBD extends BD 
{ 
    // Campos de la tabla. 
    public $id;      
    public $nombre; 
    public $email; 
 
    public function Insertar() 
    { 
        $sql = "INSERT INTO clientes VALUES". 
               " (default, '$this->nombre', '$this->email')"; 
 
        return $this->_ejecutar($sql); 
    } 
 
    public function Modificar() 
    { 
        $sql = "UPDATE clientes SET" . 
               " nombre='$this->nombre', email='$this->email'" .  
               " WHERE id=$this->id"; 
 
        return $this->_ejecutar($sql); 
    } 
 
    public function Borrar() 
    { 
        $sql = "DELETE FROM clientes WHERE id=$this->id"; 
 
        return $this->_ejecutar($sql); 
    } 
 
    public function Seleccionar() 
    { 
        $sql = 'SELECT * FROM clientes'; 
 
        // Si me han pasado un id, obtenemos solo el registro indicado. 
        if ($this->id != 0) 
            $sql .= " WHERE id=$this->id"; 
 
        $this->filas = $this->_consultar($sql); 
 
        if ($this->filas == null)
                        return false; 
 
        if ($this->id != 0) 
        { 
            // Guardamos los campos en las propiedades. 
            $this->nombre = $this->filas[0]->nombre; 
            $this->email  = $this->filas[0]->email; 
        } 
 
        return true; 
    } 
} 
?> 