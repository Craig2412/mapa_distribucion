<?php

namespace App\Domain\Permissions\Service;

use App\Domain\Permissions\Repository\PermissionsRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class PermissionsValidator
{
    private PermissionsRepository $repository;

    public function __construct(PermissionsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validatePermissionsUpdate(int $requirementsId, array $data): void
    {
        if (!$this->repository->existsPermissionsId($requirementsId)) {
            throw new DomainException(sprintf('Permissions not found: %s', $requirementsId));
        }

        $this->validatePermissions($data);
    }

    public function validatePermissions(array $data): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($data, $this->createConstraints());

        if ($violations->count()) {
            throw new ValidationFailedException('Please check your input', $violations);
        }
    }

    private function createConstraints(): Constraint
    {
        $constraint = new ConstraintFactory();

        return $constraint->collection(
            [
                'name' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 50),
                        $constraint->positive(),
                    ]
                ),

                'guard_name' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 50),
                        $constraint->positive(),
                    ]
                )
            ]
        );
    }
}
