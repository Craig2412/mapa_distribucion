<?php

namespace App\Domain\Tokens\Service;

use App\Domain\Tokens\Repository\TokensRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class TokensUpdater
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
            ->addFileHandler('tokens_updater.log')
            ->createLogger();
    }

    public function updateTokens(int $tokensId, array $data): array
    {
        // Input validation
        $this->tokensValidator->validateTokensUpdate($tokensId, $data);

        // Update the row
        $values = $this->repository->updateTokens($tokensId, $data);
        // Logging
        $this->logger->info(sprintf('Tokens updated successfully: %s', $tokensId));
        return $values;
    }
}
