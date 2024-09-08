<?php

namespace App\Domain\Requerimientos\Service;

use App\Domain\Requerimientos\Repository\RequerimientosRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class RequerimientosValidator
{
    private RequerimientosRepository $repository;

    public function __construct(RequerimientosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateRequerimientosUpdate(int $requerimientosId, array $data): void
    {
        if (!$this->repository->existsRequerimientosId($requerimientosId)) {
            throw new DomainException(sprintf('Requerimientos not found: %s', $requerimientosId));
        }

        $this->validateRequerimientos($data);
    }

    public function validateRequerimientos(array $data): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($data, $this->createConstraints());

        if ($violations->count()) {
            throw new ValidationFailedException('Error en los datos, intente mas tarde', $violations);
        }
    }

    private function createConstraints(): Constraint
    {
        $constraint = new ConstraintFactory();

        return $constraint->collection(
            [
                'agent_name' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 500)
                    ]
                ),
                'agent_lastname' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 500)
                    ]
                ),
                'agent_identification' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 500)

                    ]
                ),
                'agent_rif' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 500)
                    ]
                ),
                'agent_gender' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 2),
                        $constraint->positive()
                    ]
                    ),
                'agent_type' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 2),
                        $constraint->positive()
                    ]
                ),
                'agent_number_type' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 15),
                        $constraint->positive()
                    ]
                ),
                'agent_telefone' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 11),
                        $constraint->positive()
                    ]
                ),
                'agent_telefone_alternative' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 11),
                        $constraint->positive()
                    ]
                ),
                'agent_email' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 500),
                        $constraint->positive()
                    ]
                ),
                'agent_email_alternative' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 500),
                        $constraint->positive()
                    ]
                ),
                'agent_number' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(0, 15)
                    ]
                ),
                'agent_date_inscription' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 25),
                        $constraint->positive()
                    ]
                ),
                'agent_management' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 2)
                    ]
                )
            ]
        );
    }
}
