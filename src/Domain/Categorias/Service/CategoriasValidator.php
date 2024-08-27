<?php

namespace App\Domain\Categorias\Service;

use App\Domain\Categorias\Repository\CategoriasRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class CategoriasValidator
{
    private CategoriasRepository $repository;

    public function __construct(CategoriasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateCategoriasUpdate(int $categoriasId, array $data): void
    {
        if (!$this->repository->existsCategoriasId($categoriasId)) {
            throw new DomainException(sprintf('Categorias not found: %s', $categoriasId));
        }

        $this->validateCategorias($data);
    }

    public function validateCategorias(array $data): void
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
                'user_requests_ip' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(null, 100),
                        $constraint->positive()
                    ]
                )               
            ]
        );
    }
}
