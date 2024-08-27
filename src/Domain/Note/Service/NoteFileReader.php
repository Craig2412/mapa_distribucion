<?php

namespace App\Domain\Note\Service;

use App\Domain\Note\Data\NoteFileReaderResult;
use App\Domain\Note\Repository\NoteFileRepository;

/**
 * Service.
 */
final class NoteFileReader
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
     * Read a noteFile.
     *
     * @param int $noteFileId The noteFile id
     *
     * @return NoteFileReaderResult The result
     */
    public function getNoteFile(int $noteFileId): NoteFileReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $noteFileRow = $this->repository->getNoteFileById($noteFileId);

        // Optional: Add or invoke your complex business logic here
        // ...
        // Create domain result
        $result = new NoteFileReaderResult();
            $result->id = $noteFileRow['id'];
            $result->nombre = $noteFileRow['nombre'];
            $result->id_note = $noteFileRow['id_note'];
            $result->src = $noteFileRow['src'];
            $result->type_file = $noteFileRow['type_file'];
        return $result;
    }
}
