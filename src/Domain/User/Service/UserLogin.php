<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use App\Domain\Token\Service\TokenFinder;
use App\Domain\Token\Service\TokenCreator;
use App\Domain\Token\Service\TokenDeleter;
use App\Domain\User\Data\UserLoginResult;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class UserLogin
{

    private UserRepository $repository;
    
    private LoggerInterface $logger;

    private TokenFinder $tokenFinder;
    private TokenCreator $tokenCreator;
    private TokenDeleter $tokenDeleter;

    public function __construct(
        UserRepository $repository,
        LoggerFactory $loggerFactory,
        TokenFinder $tokenFinder,
        TokenCreator $tokenCreator,
        TokenDeleter $tokenDeleter
    ) {
        $this->repository = $repository;
        $this->tokenDeleter = $tokenDeleter;
        $this->tokenCreator = $tokenCreator;
        $this->tokenFinder = $tokenFinder;
        $this->logger = $loggerFactory
            ->addFileHandler('user_login.log')
            ->createLogger();
    }

    public function loginUser(array $data): UserLoginResult
    {
        // Get user and get new user ID
        $data = [ 'email' => $data["user"],
                  'pass' => $data["pass"]];

        $user = $this->repository->getUserLogin($data['email'], $data['pass']);
        $token = $this->tokenFinder->finderToken($user['id']);
        if (count($token)===0) {
            $token = $this->tokenCreator->createToken(["id_user"=>$user['id'], "scope"=>$user['id_role'], "ente"=>$user['role']]);
        }else {
            $deleteToken = $this->tokenDeleter->deleteToken($token["id"]);
            $token = $this->tokenCreator->createToken(["id_user"=>$user['id'], "scope"=>$user['id_role'], "ente"=>$user['role']]);
        }
        // Logging
        $this->logger->info(sprintf('User reader successfully: %s', $user));

        $result = new UserLoginResult();
        $result->id = $user['id'];
        $result->token = $token['token'];

        return $result;
    }
}
