<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use App\Domain\Token\Service\TokenFinder;
use App\Domain\Token\Service\TokenCreator;
use App\Domain\User\Data\UserLoginResult;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class UserLogin
{

    private UserRepository $repository;
    
    private LoggerInterface $logger;

    private TokenFinder $tokenFinder;
    private TokenCreator $tokenCreator;

    public function __construct(
        UserRepository $repository,
        LoggerFactory $loggerFactory,
        TokenFinder $tokenFinder,
        TokenCreator $tokenCreator
    ) {
        $this->repository = $repository;
        $this->tokenCreator = $tokenCreator;
        $this->tokenFinder = $tokenFinder;
        $this->logger = $loggerFactory
            ->addFileHandler('user_login.log')
            ->createLogger();
    }

    public function loginUser(array $data): UserLoginResult
    {
        // Get user and get new user ID
        $data = json_decode($data['body']);
        $data = [ 'email' => $data->user,
                  'pass' => $data->pass];
       // var_dump($data->user);
        $user = $this->repository->getUserLogin($data['email'], $data['pass']);
        $token = $this->tokenFinder->finderToken($user['id']);
        if (count($token)===0) {
            $token = $this->tokenCreator->createToken(["user_id"=>$user['id'], "scope"=>$user['id_role']]);
        }
        // Logging
        $this->logger->info(sprintf('User reader successfully: %s', $user));

        $result = new UserLoginResult();
        $result->id = $user['id'];
        $result->token = $token['token'];

        return $result;
    }
}
