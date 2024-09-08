<?php

namespace App\Domain\Mensaje\Service;

use App\Domain\Mensaje\Repository\MensajeRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class MensajeValidatorUpdate
{
    private MensajeRepository $repository;

    public function __construct(MensajeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateMensajeUpdate(int $mensajeId, array $data): void
    {
        if (!$this->repository->existsMensajeId($mensajeId)) {
            throw new DomainException(sprintf('Mensaje not found: %s', $mensajeId));
        }

        $this->validateMensaje($data);
    }

    public function validateMensaje(array $data): void
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
                'mensaje' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,300),
                    ]),
                'id_condicion' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,2),
                        $constraint->positive()
                    ])
            ]
        );
    }
}
