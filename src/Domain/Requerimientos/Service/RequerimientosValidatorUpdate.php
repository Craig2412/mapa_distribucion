<?php

namespace App\Domain\Requerimientos\Service;

use App\Domain\Requerimientos\Repository\RequerimientosRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class RequerimientosValidatorUpdate
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
            throw new ValidationFailedException('Please check your input', $violations);
        }
    }

    private function createConstraints(): Constraint
    {
        $constraint = new ConstraintFactory();

        return $constraint->collection(
            [
                'id_formato_cita' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,2),
                        $constraint->positive()
                    ]
                ),
                'id_condicion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,1),
                        $constraint->positive()
                    ]
                ),
                'id_estado' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,4),
                        $constraint->positive()
                    ]
                ),
                'id_pais' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,10),
                        $constraint->positive()
                    ]
                ),
                'id_estado_pais' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,10),
                        $constraint->positive()
                    ]
                ),
                'id_trabajador' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,10),
                        $constraint->positive()
                    ]
                )
            ]
        );
    }
}
