<?php

namespace App\Domain\Roles\Service;

use App\Domain\Roles\Repository\RolesRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class RolesValidator
{
    private RolesRepository $repository;

    public function __construct(RolesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateRolesUpdate(int $rolesId, array $data): void
    {
        if (!$this->repository->existsRolesId($rolesId)) {
            throw new DomainException(sprintf('Roles not found: %s', $rolesId));
        }

        $this->validateRoles($data);
    }

    public function validateRoles(array $data): void
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
                'role' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 30)
                    ]
                )
            ]
        );
    }
}
