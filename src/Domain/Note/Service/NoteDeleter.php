<?php

namespace App\Domain\Note\Service;

use App\Domain\Note\Repository\NoteRepository;

final class NoteDeleter
{
    private NoteRepository $repository;

    public function __construct(NoteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteNote(int $noteId): void
    {
        $this->repository->deleteNoteById($noteId);
    }
}
