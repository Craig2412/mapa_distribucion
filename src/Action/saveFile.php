<?php
namespace App\Action;

final class saveFile
{
    private saveFile $saveFile;

    private JsonRenderer $renderer;

   public function guardarArchivo($archivo) {
    $rutaDestino = __DIR__.'./../../../resources/notesFiles/';
    $nombreArchivo = uniqid() . '_' . $archivo['name'];
    $rutaCompleta = $rutaDestino . $nombreArchivo;
    $tipoArchivo = $_FILES['file']['type'];

    if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
        return [
                "nombre" => $nombreArchivo,
                "src" => $rutaCompleta, 
                "type_file" => $tipoArchivo
               ];
    } else {
        return false;
    }
}
}
