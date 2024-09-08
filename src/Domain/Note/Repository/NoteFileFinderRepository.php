<?php

namespace App\Domain\Note\Repository;

use App\Factory\QueryFactory;

final class NoteFileFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findNoteFile($noteId): array
    {
        //Paginador
        $query = $this->queryFactory->newSelect('type_files');
        $query->select(
            [
                'type_files.id as id',
                'files.file_name',
                'files.file_type',   
                'type_files.type_file_name'
            ]
        )->leftjoin(['files'=>'files'],'type_files.id =files.file_type AND files.file_id_agent ='.$noteId);
        $query->order(['file_type' => 'ASC']);
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
