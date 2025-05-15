<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\AbstractOAuthAuthenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use RuntimeException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class GoogleAuthenticator extends AbstractOAuthAuthenticator 
{
    protected $serviceName = "google";

    protected function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UserRepository $repository): ?User {

        if (!($resourceOwner instanceof GoogleUser)) {
            throw new RuntimeException("Expecting google user");            
        }

        if (!($resourceOwner->toArray()['email_verified'] ?? false)) {
            throw new AuthenticationException("Email not verified");
        }

        return $repository->findOneBy([
            'google_id' => $resourceOwner->getId(),
            'email' => $resourceOwner->getEmail(),
        ]) ;
    }

}
