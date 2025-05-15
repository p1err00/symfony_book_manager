<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Client\Provider\GoogleUser;

class RegistrationService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Crée et persiste un nouvel utilisateur à partir des infos GoogleUser
     *
     * @param GoogleUser $googleUser
     * @return User
     */
    public function persist(GoogleUser $googleUser): User
    {
        $user = new User();

        $user->setEmail($googleUser->getEmail());
        $user->setGoogleId($googleUser->getId());
        $user->setRoles(['ROLE_USER']); // rôle par défaut
        $user->setGoogleAccessToken(null); // sera mis à jour plus tard
        $user->setGoogleTokenExpiresAt(null);

        // Autres champs possibles :
        // $user->setFullName($googleUser->getName());
        // $user->setAvatarUrl($googleUser->getAvatar());

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
