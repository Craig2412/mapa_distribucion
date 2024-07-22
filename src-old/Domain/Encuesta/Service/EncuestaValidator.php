<?php

namespace App\Domain\Encuesta\Service;

use App\Domain\Encuesta\Repository\EncuestaRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class EncuestaValidator
{
    private EncuestaRepository $repository;

    public function __construct(EncuestaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateEncuestaUpdate(int $encuestasId, array $data): void
    {
        if (!$this->repository->existsEncuestaId($encuestasId)) {
            throw new DomainException(sprintf('Encuesta not found: %s', $encuestasId));
        }

        $this->validateEncuesta($data);
    }

    public function validateEncuesta(array $data): void
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
                'id_funcionario' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive()
                    ]
                    ),
                'id_pregunta' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive()
                    ]
                    ),
                'respuesta' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,300),
                        $constraint->positive()
                    ]
                )
            ]
        );
    }
}
