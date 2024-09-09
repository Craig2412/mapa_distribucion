<?php

namespace App\Domain\RepresentanteLegal\Service;

use App\Domain\RepresentanteLegal\Repository\RepresentanteLegalRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class RepresentanteLegalValidator
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
            throw new ValidationFailedException('Verificar Datos.', $violations);
        }
    }

    private function createConstraints(): Constraint
    {
        $constraint = new ConstraintFactory();

        return $constraint->collection(
            [
                'nombres' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(2, 150)
                    ]
                    ),
                'apellidos' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 150)
                    ]
                    ),
                'identificacion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1, 10)
                    ]
                    ),
                'correo' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->email(),
                        $constraint->length(1, 200)
                    ]
                    ),
                'telefono' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 11)
                    ]
                    ),
            ]
        );
    }
}
