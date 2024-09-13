<?php

namespace App\Domain\RubrosOrigen\Service;

use App\Domain\RubrosOrigen\Repository\RubrosOrigenRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class RubrosOrigenValidatorUpdate
{
    private RubrosOrigenRepository $repository;

    public function __construct(RubrosOrigenRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateRubrosOrigenUpdate(int $rubrosOrigensId, array $data): void
    {
        if (!$this->repository->existsRubrosOrigenId($rubrosOrigensId)) {
            throw new DomainException(sprintf('RubrosOrigen not found: %s', $rubrosOrigensId));
        }

        $this->validateRubrosOrigen($data);
    }

    public function validateRubrosOrigen(array $data): void
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
                'rubro' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(2, 100)
                    ]
                    ),
                'presentacion' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->length(2, 100)
                    ]
                    ),
                'precio_ves' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1, 11)
                    ]
                    ),
                'precio_ptr' => $constraint->optional(
                    [
                        $constraint->notBlank(),
                        $constraint->positive(),
                        $constraint->length(1, 11)
                    ]
                    ),
            ]
        );
    }
}
