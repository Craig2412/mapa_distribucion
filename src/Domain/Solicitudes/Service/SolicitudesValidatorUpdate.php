<?php

namespace App\Domain\Solicitudes\Service;

use App\Domain\Solicitudes\Repository\SolicitudesRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class SolicitudesValidatorUpdate
{
    private SolicitudesRepository $repository;

    public function __construct(SolicitudesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateSolicitudesUpdate(int $solicitudesId, array $data): void
    {
        if (!$this->repository->existsSolicitudesId($solicitudesId)) {
            throw new DomainException(sprintf('Solicitudes not found: %s', $solicitudesId));
        }

        $this->validateSolicitudes($data);
    }

    public function validateSolicitudes(array $data): void
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
                'id_condicion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 10),
                        $constraint->positive()
                    ]
                ),
                'id_estado' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 10),
                        $constraint->positive()
                    ]
                ),
                'respuesta' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 500),
                    ]
                ),
                'descripcion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 500)
                    ]
                )
            ]
        );
    }
}
