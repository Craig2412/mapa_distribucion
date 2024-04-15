<?php

namespace App\Domain\Token\Service;

use App\Domain\Token\Repository\TokenRepository;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use App\Auth\Auth;

final class TokenCreator
{
    private TokenRepository $repository;

    private LoggerInterface $logger;

    public function __construct(
        TokenRepository $repository,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->logger = $loggerFactory
            ->addFileHandler('user_creator.log')
            ->createLogger();
    }

    public function createToken(array $data): array
    {

        $token = Auth::SignIn(['user_id'=>$data['id'], 'scope'=>$data['id_role']]);
        // Insert customer and get new customer ID
        $token = $this->repository->insertToken(['token'=> $token, 'id_user' => $data['id']]);

        // Logging
        $this->logger->info(sprintf('Token created successfully: %s', $token));

        return $token;
    }
}
