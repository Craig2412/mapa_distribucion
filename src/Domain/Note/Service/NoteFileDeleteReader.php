<?php

namespace App\Domain\Note\Service;

use App\Domain\Note\Data\NoteFileReaderResult;
use App\Domain\Note\Repository\NoteFileRepository;

function deleteFile($rutaArchivo) {
    if (file_exists($rutaArchivo)) {
        unlink($rutaArchivo);
        return true;
    } else {
        return false;
    }
}

/**
 * Service.
 */
final class NoteFileDeleteReader
{
    private NoteFileRepository $repository;

    /**
     * The constructor.
     *
     * @param NoteFileRepository $repository The repository
     */
    public function __construct(NoteFileRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a noteFileDelete.
     *
     * @param int $noteFileDeleteId The noteFileDelete id
     *
     * @return NoteFileReaderResult The result
     */
    public function getNoteFileDelete(int $noteFileDeleteId): NoteFileReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $noteFileDeleteRow = $this->repository->getNoteFileById($noteFileDeleteId);

        // Optional: Add or invoke your complex business logic here
        // ...
        // Create domain result
        $result = new NoteFileReaderResult();
            $result->id = $noteFileDeleteRow['id'];
            $result->nombre = $noteFileDeleteRow['nombre'];
            $result->id_note = $noteFileDeleteRow['id_note'];
            $result->src = $noteFileDeleteRow['src'];
            $result->type_file = $noteFileDeleteRow['type_file'];

            $this->repository->deleteNoteFileById($result->id);
                        
            $rutaArchivo = $result->src;
            if (deleteFile($rutaArchivo)) {
                $result->fileDelete = "El archivo ha sido eliminado correctamente.";
            } else {
                $result->fileDelete = "El archivo no existe o no se pudo eliminar.";
            }

        return $result;
    }
}
