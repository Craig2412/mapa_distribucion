<?php

namespace App\Domain\Note\Service;

use App\Domain\Note\Repository\NoteRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class NoteUpdater
{
    private NoteRepository $repositoryUpdate;

    private NoteValidatorUpdate $noteValidatorUpdate;

    private LoggerInterface $logger;

    public function __construct(
        NoteRepository $repositoryUpdate,
        NoteValidatorUpdate $noteValidatorUpdate,
        LoggerFactory $loggerFactory
    ) {
        $this->repositoryUpdate = $repositoryUpdate;
        $this->noteValidatorUpdate = $noteValidatorUpdate;
        $this->logger = $loggerFactory
            ->addFileHandler('note_updater.log')
            ->createLogger();
    }

    public function updateNote(int $noteId, array $data): array
    {

        // Input validation
        $this->noteValidatorUpdate->validateNoteUpdate($noteId, $data);

        // Update the row
        $var = $this->repositoryUpdate->updateNote($noteId, $data);
        

        // Logging
        $this->logger->info(sprintf('Note updated successfully: %s', $noteId));

        return $var;
    }
}
