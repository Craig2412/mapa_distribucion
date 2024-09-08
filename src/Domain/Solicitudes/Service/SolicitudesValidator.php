<?php

namespace App\Domain\Solicitudes\Service;

use App\Domain\Solicitudes\Repository\SolicitudesRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class SolicitudesValidator
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
                'signature_name' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 500)
                    ]                
                ),
                'signature_identification' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 15),
                        $constraint->positive()
                    ]
                ),
                'signature_direcction' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 500)
                    ]
                ),
                'signature_telefone' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 11),
                        $constraint->positive()
                    ]
                ),
                'signature_alternative_telefone' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 11),
                        $constraint->positive()
                    ]
                ),
                'signature_email' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 300)
                    ]
                ),
                'signature_alternative_email' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 300)
                    ]
                ),
                'signature_lat' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 500)
                    ]
                ),
                'signature_lng' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 500)
                    ]
                ),
            ]
        );
    }
}
