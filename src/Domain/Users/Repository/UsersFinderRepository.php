<?php

namespace App\Domain\Users\Repository;

use App\Factory\QueryFactory;

final class UsersFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findUsers($token): array
    {
        $query = $this->queryFactory->newSelect('tokens');

        $query->select(
            [
                'tokens.id',
                'tokens.id_user',
                'users.name',
                'users.surname',
                'users.email',
                'users.identification'
            ]
        )  
        ->leftjoin(['users'=>'users'], 'users.id = tokens.id_user');
        
        $query->where(['tokens.token' => "$token"]);

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
