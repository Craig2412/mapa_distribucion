<?php

namespace App\Domain\UsuariosBufetes\Service;

use App\Domain\UsuariosBufetes\Repository\UsuariosBufetesRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class UsuariosBufetesValidator
{
    private UsuariosBufetesRepository $repository;

    public function __construct(UsuariosBufetesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateUsuariosBufetesUpdate(int $usuariosbufetesId, array $data): void
    {
        if (!$this->repository->existsUsuariosBufetesId($usuariosbufetesId)) {
            throw new DomainException(sprintf('UsuariosBufetes not found: %s', $usuariosbufetesId));
        }

        $this->validateUsuariosBufetes($data);
    }

    public function validateUsuariosBufetes(array $data): void
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
                    'id_signature' => $constraint->required(
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
