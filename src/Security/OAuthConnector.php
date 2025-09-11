<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping\PropertyAccessors\PropertyAccessor;
use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

final class OAuthConnector implements AccountConnectorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly array $properties
    ) {
    }

    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        if (!isset($this->properties[$response->getResourceOwner()->getName()])) {
            return;
        }

        $property = new PropertyAccessor();
        $property->setValue($user, $this->properties[$response->getResourceOwner()->getName()], $response->getUserIdentifier());

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}