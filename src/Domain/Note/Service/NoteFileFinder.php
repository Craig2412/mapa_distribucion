<?php

namespace App\Domain\Note\Service;

use App\Domain\Note\Data\NoteFileFinderItem;
use App\Domain\Note\Data\NoteFileFinderResult;
use App\Domain\Note\Repository\NoteFileFinderRepository;

final class NoteFileFinder
{
    private NoteFileFinderRepository $repository;

    public function __construct(NoteFileFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findNoteFile($noteId): NoteFileFinderResult
    {
        // Input validation
        $noteFile = $this->repository->findNoteFile($noteId);

        return $this->createResult($noteFile);
    }

    private function createResult(array $noteFileRows): NoteFileFinderResult
    {
        $result = new NoteFileFinderResult();

        foreach ($noteFileRows as $noteFileRow) {
            $noteFile = new NoteFileFinderItem();
           
            $noteFile->id = $noteFileRow['id'];
            $noteFile->file_name = $noteFileRow['file_name'];
            $noteFile->file_type = $noteFileRow['file_type'];
            $noteFile->type_file_name = $noteFileRow['type_file_name'];

            $result->noteFile[] = $noteFile;
        }

        return $result;
    }
}
