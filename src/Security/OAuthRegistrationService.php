<?php

namespace App\Security;

use App\Repository\UserRepository;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

final class OAuthRegistrationService
{

    public function __construct(
        UserRepository $repository
    ) {
    }

    /**
     * Summary of persist
     * @param \League\OAuth2\Client\Provider\ResourceOwnerInterface $resourceOwner
     * @return \App\Security\User
     */
    public function persist(ResourceOwnerInterface $resourceOwner): User
    {

        $user = (new User())
            ->setEmail($resourceOwner->getEmail())
            ->setGoogleId($resourceOwner->getId());

        $this->repository->add($user, true);
        return $user;
    }
}