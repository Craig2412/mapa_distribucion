<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class UserCreator
{
    private UserRepository $repository;

    private UserValidator $userValidator;

    private LoggerInterface $logger;

    public function __construct(
        UserRepository $repository,
        UserValidator $userValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->userValidator = $userValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('user_creator.log')
            ->createLogger();
    }

    public function createUser(array $data): array
    {
        // Input validation
        $this->userValidator->validateUser($data);

        // Insert customer and get new customer ID
        $user = $this->repository->insertUser($data);

        // Logging
        $this->logger->info(sprintf('User created successfully: %s', $user));

        return $user;
    }
}
