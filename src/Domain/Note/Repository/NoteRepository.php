<?php

namespace App\Domain\Note\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class NoteRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->fecha = date("Y-m-d H:i:s" , time() - 21600); // Aca esta la fecha del dia (UNIX) menos 5  horas por el uso horario de venezuela
        $this->queryFactory = $queryFactory;

    }

    public function insertNote(array $note): int
    {
        return (int)$this->queryFactory->newInsert('notes', $this->toRow($note))
            ->execute()
            ->lastInsertId();
    }

    public function getNoteById(int $noteId): array
    {
        
        $query = $this->queryFactory->newSelect('notes');
        $query->select(
            [
                'notes.id',
                'notes.note',
                'notes.id_user',
                'users.name',
                'notes.id_task',
                'tasks.title',
                'file.id AS id_file',
                'file.nombre AS file_name',
                'notes.created',
                'notes.updated'
            ]
        )  
        ->leftjoin(['file'=>'note_files'], 'file.id_note = notes.id')
        ->leftjoin(['users'=>'users'], 'users.id = notes.id_user')
        ->leftjoin(['tasks'=>'tasks'], 'tasks.id = notes.id_task');

        $query->where(['notes.id' => $noteId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Note not found: %s', $noteId));
        }
        return $row;
    }

    public function updateNote(int $noteId, array $note): array
    {
        $row = $this->toRowUpdate($note);
        $row["updated"] = $this->fecha; 
        $this->queryFactory->newUpdate('notes', $row)
            ->where(['id' => $noteId])
            ->execute();
            return $row;
    }

    public function existsNoteId(int $noteId): bool
    {
        $query = $this->queryFactory->newSelect('notes');
        $query->select('id')->where(['id' => $noteId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteNoteById(int $noteId): void
    {
        $this->queryFactory->newDelete('notes')
            ->where(['id' => $noteId])
            ->execute();
    }

    private function toRow(array $note): array
    { 
        return [
            'note' => strtoupper($note['note']),
            'id_user' => $note['id_user'],
            'id_task' => $note['id_task'],
            'created' => $this->fecha,
            'updated' => null
        ];
    }

    private function toRowUpdate(array $note): array
    {        
        return [
            'note' => strtoupper($note['note']),
            'updated' => null
        ];
    }
}