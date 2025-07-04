<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibroPrestamoDetalle extends Model
{
    use HasFactory;

    protected $table = 'librosprestamosdetalles';
    protected $primaryKey = ['idLibrosPrestamo', 'idLibro']; // Clave compuesta
    public $incrementing = false;
    public $timestamps = false;

    /**Función que retorna un objeto del modelo librosprestamosdetalles.*/
    public function selectLibrosPrestamosDetalles($idLibrosPrestamo,$idLibro){
        return LibroPrestamoDetalle::where('idLibrosPrestamo', $idLibrosPrestamo)->where('idLibro', $idLibro)->first(); 
    }
}
