<?php

namespace App\Domain\Note\Service;

use App\Domain\Note\Data\NoteFinderItem;
use App\Domain\Note\Data\NoteFinderResult;
use App\Domain\Note\Repository\NoteFinderRepository;

final class NoteFinder
{
    private NoteFinderRepository $repository;

    public function __construct(NoteFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findNote($nro_pag,$where,$cant_registros,$taskId): NoteFinderResult
    {
        // Input validation
        $note = $this->repository->findNote($nro_pag,$where,$cant_registros,$taskId);

        return $this->createResult($note);
    }

    private function createResult(array $noteRows): NoteFinderResult
    {
        $result = new NoteFinderResult();

        foreach ($noteRows as $noteRow) {
            $note = new NoteFinderItem();
           
            $note->id = $noteRow['id'];
            $note->note = $noteRow['note'];
            $note->id_user = $noteRow['id_user'];
            $note->name = $noteRow['name'];
            $note->id_task = $noteRow['id_task'];
            $note->id_file = $noteRow['id_file'];
            $note->title = $noteRow['title'];
            $note->created = $noteRow['created'];
            $note->updated = $noteRow['updated'];

            $result->note[] = $note;
        }

        return $result;
    }
}
