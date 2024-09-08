<?php

namespace App\Domain\Note\Service;

use App\Domain\Note\Repository\NoteFileRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class NoteFileCreator
{
    private NoteFileRepository $repository;

    private NoteFileValidator $noteFileValidator;

    private LoggerInterface $logger;

    public function __construct(
        NoteFileRepository $repository,
        NoteFileValidator $noteFileValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->noteFileValidator = $noteFileValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('noteFile_creator.log')
            ->createLogger();
    }

    public function createNoteFile(array $data): int
    {
        // Input validation
            $this->noteFileValidator->validateNoteFile($data);
        
        // Insert noteFile and get new noteFile ID
            $noteFileId = $this->repository->insertNoteFile($data);

        // Logging
        $this->logger->info(sprintf('NoteFile created successfully: %s', $noteFileId));

        return $noteFileId;
    }
}
