<?php

namespace App\Domain\Preguntas\Service;

use App\Domain\Preguntas\Repository\PreguntasRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class PreguntasValidator
{
    private PreguntasRepository $repository;

    public function __construct(PreguntasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validatePreguntasUpdate(int $preguntassId, array $data): void
    {
        if (!$this->repository->existsPreguntasId($preguntassId)) {
            throw new DomainException(sprintf('Preguntas not found: %s', $preguntassId));
        }

        $this->validatePreguntas($data);
    }

    public function validatePreguntas(array $data): void
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
                'pregunta' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 100),
                    ]
                )
            ]
        );
    }
}
