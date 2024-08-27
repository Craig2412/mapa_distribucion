<?php

namespace App\Domain\Areas\Service;

use App\Domain\Areas\Repository\AreasRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class AreasValidator
{
    private AreasRepository $repository;

    public function __construct(AreasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateAreasUpdate(int $areasId, array $data): void
    {
        if (!$this->repository->existsAreasId($areasId)) {
            throw new DomainException(sprintf('Areas not found: %s', $areasId));
        }

        $this->validateAreas($data);
    }

    public function validateAreas(array $data): void
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
                'area' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 150),
                        $constraint->positive()
                    ]
                )                
            ]
        );
    }
}
