<?php

namespace Svnfqt\ProjectTrophies\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\ODM\MongoDB\DocumentManager;

use Svnfqt\ProjectTrophies\Document\User;

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

    public function createUser()
    {
        return new User();
    }

    public function loadUsers()
    {
        return $this->getRepository()->findAllOrderedByUsername();
    }

    public function loadUserByUsername($username)
    {
        if (!$user = $this->getRepository()->findOneByUsername($username)) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        // TODO DRY
        $class = get_class($user);

        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function persistUser(UserInterface $user)
    {
        // TODO DRY
        $class = get_class($user);

        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        try {
            $this->documentManager->persist($user);
            $this->documentManager->flush();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function removeUser(UserInterface $user)
    {
        // TODO DRY
        $class = get_class($user);

        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        try {
            $this->documentManager->remove($user);
            $this->documentManager->flush();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function supportsClass($class)
    {
        return $class === 'Svnfqt\ProjectTrophies\Document\User';
    }
}
