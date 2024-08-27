<?php

namespace App\Domain\Tokens\Service;

use App\Domain\Tokens\Repository\TokensRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class TokensCreator
{
    private TokensRepository $repository;

    private TokensValidator $tokensValidator;

    private LoggerInterface $logger;

    public function __construct(
        TokensRepository $repository,
        TokensValidator $tokensValidator,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->tokensValidator = $tokensValidator;
        $this->logger = $loggerFactory
            ->addFileHandler('tokens_creator.log')
            ->createLogger();
    }

    public function createTokens(array $data): int
    {
        // Input validation
        $this->tokensValidator->validateTokens($data);

        // Insert tokens and get new tokens ID
        $tokensId = $this->repository->insertTokens($data);

        // Logging
        $this->logger->info(sprintf('Tokens created successfully: %s', $tokensId));

        return $tokensId;
    }
}
