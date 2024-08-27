<?php

namespace App\Domain\Tokens\Service;

use App\Domain\Tokens\Repository\TokensRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class TokensValidator
{
    private TokensRepository $repository;

    public function __construct(TokensRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateTokensUpdate(int $tokensId, array $data): void
    {
        if (!$this->repository->existsTokensId($tokensId)) {
            throw new DomainException(sprintf('Tokens not found: %s', $tokensId));
        }

        $this->validateTokens($data);
    }

    public function validateTokens(array $data): void
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
                'token' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(5, 500)
                    ]
                ),
                'id_usuario' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1, 10),
                        $constraint->positive()
                    ]
                )             
            ]
        );
    }
}
