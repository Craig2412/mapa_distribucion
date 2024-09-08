<?php

namespace App\Domain\Note\Service;

use App\Domain\Note\Repository\NoteRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class NoteCreator
{
    private NoteRepository $repository;

    private NoteValidator $noteValidator;

    private LoggerInterface $logger;

    public function __construct(
        NoteRepository $repository,
        NoteValidator $noteValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->noteValidator = $noteValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('note_creator.log')
            ->createLogger();
    }

    public function createNote(array $data): int
    {
        // Input validation
            $this->noteValidator->validateNote($data);
        
        // Insert note and get new note ID
            $noteId = $this->repository->insertNote($data);

        // Logging
        $this->logger->info(sprintf('Note created successfully: %s', $noteId));

        return $noteId;
    }
}
