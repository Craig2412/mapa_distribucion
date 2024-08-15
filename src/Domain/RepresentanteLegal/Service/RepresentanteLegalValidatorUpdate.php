<?php

namespace App\Domain\RepresentanteLegal\Service;

use App\Domain\RepresentanteLegal\Repository\RepresentanteLegalRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class RepresentanteLegalValidatorUpdate
{
    private RepresentanteLegalRepository $repository;

    public function __construct(RepresentanteLegalRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateRepresentanteLegalUpdate(int $representanteLegalsId, array $data): void
    {
        if (!$this->repository->existsRepresentanteLegalId($representanteLegalsId)) {
            throw new DomainException(sprintf('RepresentanteLegal not found: %s', $representanteLegalsId));
        }

        $this->validateRepresentanteLegal($data);
    }

    public function validateRepresentanteLegal(array $data): void
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
                'nombres' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(2, 150)
                    ]
                    ),
                'apellidos' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(2, 150)
                    ]
                    ),
                'identificacion' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(6, 10)
                    ]
                    ),
                'correo' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->email(),
                        $constraint->length(9, 100)
                    ]
                    ),
                'telefono' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(10, 11)
                    ]
                )
            ]
        );
    }
}
