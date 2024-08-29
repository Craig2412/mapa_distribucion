<?php

namespace App\Domain\TiposMovilizacion\Service;

use App\Domain\TiposMovilizacion\Repository\TiposMovilizacionRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class TiposMovilizacionValidatorUpdate
{
    private TiposMovilizacionRepository $repository;

    public function __construct(TiposMovilizacionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateTiposMovilizacionUpdate(int $tiposMovilizacionsId, array $data): void
    {
        if (!$this->repository->existsTiposMovilizacionId($tiposMovilizacionsId)) {
            throw new DomainException(sprintf('TiposMovilizacion not found: %s', $tiposMovilizacionsId));
        }

        $this->validateTiposMovilizacion($data);
    }

    public function validateTiposMovilizacion(array $data): void
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
                'tipo_movilizacion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(2, 100)
                    ]
                )
            ]
        );
    }
}
