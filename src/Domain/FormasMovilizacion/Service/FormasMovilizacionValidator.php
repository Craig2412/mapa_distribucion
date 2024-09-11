<?php

namespace App\Domain\FormasMovilizacion\Service;

use App\Domain\FormasMovilizacion\Repository\FormasMovilizacionRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class FormasMovilizacionValidator
{
    private FormasMovilizacionRepository $repository;

    public function __construct(FormasMovilizacionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateFormasMovilizacionUpdate(int $formasMovilizacionsId, array $data): void
    {
        if (!$this->repository->existsFormasMovilizacionId($formasMovilizacionsId)) {
            throw new DomainException(sprintf('FormasMovilizacion not found: %s', $formasMovilizacionsId));
        }

        $this->validateFormasMovilizacion($data);
    }

    public function validateFormasMovilizacion(array $data): void
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
                'id_mayorista' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1,3)
                    ]
                ),
                'id_tipo_movilizacion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1,3)
                    ]
                )
            ]
        );
    }
}
