<?php

namespace Svnfqt\ProjectTrophies\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\DBAL\Connection;

use Doctrine\ODM\MongoDB\DocumentManager;

class UserProvider implements UserProviderInterface
{
    protected $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->setDocumentManager($documentManager);
    }

    public function setDocumentManager(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
        return $this;
    }

    public function getDocumentManager()
    {
        return $this->documentManager;
    }

    public function getRepository()
    {
        return $this->documentManager->getRepository('Svnfqt\ProjectTrophies\Document\User');
    }

    public function loadUserByUsername($username)
    {
        if (!$user = $this->getRepository()->findOneByUsername($username)) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return new User($user->getUsername(), $user->getPassword(), $user->getRoles(), true, true, true, true);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}
