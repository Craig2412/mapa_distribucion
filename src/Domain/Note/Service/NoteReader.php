<?php

namespace App\Domain\Note\Service;

use App\Domain\Note\Data\NoteReaderResult;
use App\Domain\Note\Repository\NoteRepository;

/**
 * Service.
 */
final class NoteReader
{
    private NoteRepository $repository;

    /**
     * The constructor.
     *
     * @param NoteRepository $repository The repository
     */
    public function __construct(NoteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a note.
     *
     * @param int $noteId The note id
     *
     * @return NoteReaderResult The result
     */
    public function getNote(int $noteId): NoteReaderResult
    {
        // Input validation
        // ...

        // Fetch data from the database
        $noteRow = $this->repository->getNoteById($noteId);

        // Optional: Add or invoke your complex business logic here
        // ...
        // Create domain result
        $result = new NoteReaderResult();
            $result->id = $noteRow['id'];
            $result->note = $noteRow['note'];
            $result->id_user = $noteRow['id_user'];
            $result->name = $noteRow['name'];
            $result->id_task = $noteRow['id_task'];
            $result->title = $noteRow['title'];
            $result->id_file = $noteRow['id_file'];
            $result->file_name = $noteRow['file_name'];
            $result->created = $noteRow['created'];
            $result->updated = $noteRow['updated'];

            
        return $result;
    }
}
