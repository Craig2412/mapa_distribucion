<?php

namespace App\Domain\Note\Repository;

use App\Factory\QueryFactory;

final class NoteFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findNote($nro_pag,$where,$cant_registros,$taskId): array
    {
        //Paginador
        $limit = $cant_registros;
        $offset = ($nro_pag - 1) * $limit;
        $query = $this->queryFactory->newSelect('notes');
        //Fin Paginador
        
        $query->select(
            [
                'notes.id',
                'notes.note',
                'notes.id_user',
                'users.name',
                'notes.id_task',
                'file.id as id_file',
                'tasks.title',
                'notes.created',
                'notes.updated'
            ]
        )
        ->leftjoin(['users'=>'users'], 'users.id = notes.id_user')
        ->leftjoin(['tasks'=>'tasks'], 'tasks.id = notes.id_task')
        ->leftjoin(['file'=>'note_files'], 'file.id_note = notes.id');

        $query->where(['notes.id_task' => $taskId]);    

        //Paginador
        
        $query->offset([$offset]);
        $query->limit([$limit]);
        //Fin paginador


        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
