<?php

namespace App\Domain\Users\Service;

use App\Domain\Users\Data\UsersFinderItem;
use App\Domain\Users\Data\UsersFinderResult;
use App\Domain\Users\Repository\UsersFinderRepository;

final class UsersFinder
{
    private UsersFinderRepository $repository;

    public function __construct(UsersFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findUsers($token): UsersFinderResult
    {
        // Input validation
        // ...

        $users = $this->repository->findUsers($token);
        return $this->createResult($users);
        
    }
    private function createResult(array $usersRows): UsersFinderResult
    {
        $result = new UsersFinderResult();

        foreach ($usersRows as $usersRow) {
            $users = new UsersFinderItem();
            $users->id = $usersRow['id_user'];
            $users->name = $usersRow['name'];
            $users->surname = $usersRow['surname'];
            $users->email = $usersRow['email'];
            $users->identification = $usersRow['identification'];

            $result->users[] = $users;
        }

        return $result;
    }
}
