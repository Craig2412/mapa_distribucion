<?php

namespace App\Domain\TiposMayoristas\Service;

use App\Domain\TiposMayoristas\Repository\TiposMayoristasRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class TiposMayoristasValidator
{
    private TiposMayoristasRepository $repository;

    public function __construct(TiposMayoristasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateTiposMayoristasUpdate(int $tiposMayoristassId, array $data): void
    {
        if (!$this->repository->existsTiposMayoristasId($tiposMayoristassId)) {
            throw new DomainException(sprintf('TiposMayoristas not found: %s', $tiposMayoristassId));
        }

        $this->validateTiposMayoristas($data);
    }

    public function validateTiposMayoristas(array $data): void
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
                'tipo_mayorista' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(2, 100)
                    ]
                )
            ]
        );
    }
}
