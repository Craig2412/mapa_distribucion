<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class UserValidator
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateUserUpdate(int $userId, array $data): void
    {
        if (!$this->repository->existsCustomerId($userId)) {
            throw new DomainException(sprintf('Customer not found: %s', $userId));
        }

        $this->validateUser($data);
    }

    public function validateUser(array $data): void
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
                        $constraint->length(null, 100),
                    ]
                ),
                'surname' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 100),
                        $constraint->positive(),
                    ]
                ),
                'email' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->email(),
                        $constraint->length(null, 100),
                    ]
                ),
                'phone' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 11),
                    ]
                ),
                'id_role' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive()
                    ]
                ),
                'id_condition' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive()
                    ]
                ),
                'id_signature' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive()
                    ]
                ),
                'identification' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 10),
                    ]
                    ),
                'pass' => $constraint->required(
                    [
                        $constraint->notBlank()
                        
                    ]
                )
            ]
        );
    }
}
