<?php

namespace App\Domain\Note\Service;

use App\Domain\Note\Repository\NoteRepository;
use App\Factory\ConstraintFactory;
use DomainException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

final class NoteValidator
{
    private NoteRepository $repository;

    public function __construct(NoteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validateNoteUpdate(int $noteId, array $data): void
    {
        if (!$this->repository->existsNoteId($noteId)) {
            throw new DomainException(sprintf('Note not found: %s', $noteId));
        }

        $this->validateNote($data);
    }

    public function validateNote(array $data): void
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
                'note' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,100),
                    ]),
                'id_user' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,2),
                        $constraint->positive()
                    ]),
                'id_task' => $constraint->required(
                    [
                        $constraint->notBlank(),
                        $constraint->length(1,4),
                        $constraint->positive()
                    ]
                )
            ]
        );
    }
}
