<?php

namespace App\Domain\Cita\Service;

use App\Domain\Cita\Repository\CitaRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class CitaValidator
{
    private CitaRepository $repository;

    public function __construct(CitaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateCitaUpdate(int $citaId, array $data): void
    {
        if (!$this->repository->existsCitaId($citaId)) {
            throw new DomainException(sprintf('Cita not found: %s', $citaId));
        }

        $this->validateCita($data);
    }

    public function validateCita(array $data): void
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
                'direcction_name' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,500),
                    ]
                ),
                'direcction_estado' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1),
                        $constraint->positive()
                    ]
                ),
                'direcction_municipio' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1),
                        $constraint->positive()
                    ]
                ),
                'direcction_parroquia' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1),
                        $constraint->positive()
                    ]
                ),
                'direcction_lat' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 500),
                    ]
                ),
                'direcction_lng' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 500),
                    ]
                ),
                'direcction_id_agent' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 10),
                        $constraint->positive()
                    ]
                )
            ]
        );
    }
}
