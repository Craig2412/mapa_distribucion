<?php

namespace App\Domain\UsuariosAreas\Service;

use App\Domain\UsuariosAreas\Repository\UsuariosAreasRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class UsuariosAreasValidator
{
    private UsuariosAreasRepository $repository;

    public function __construct(UsuariosAreasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateUsuariosAreasUpdate(int $usuariosareasId, array $data): void
    {
        if (!$this->repository->existsUsuariosAreasId($usuariosareasId)) {
            throw new DomainException(sprintf('UsuariosAreas not found: %s', $usuariosareasId));
        }

        $this->validateUsuariosAreas($data);
    }

    public function validateUsuariosAreas(array $data): void
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
                    'id_agent' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,20),
                        $constraint->positive()
                    ]
                    ),
                    'id_area' => $constraint->required(
                        [
                            $constraint->notBlank(),
                            $constraint->length(1,2),
                            $constraint->positive()
                        ]
                    )                
            ]
        );
    }
}
