<?php

namespace Svnfqt\ProjectTrophies\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ODM\Document(repositoryClass="Svnfqt\ProjectTrophies\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ODM\Id
     */
    private $id;

    /**
     * @ODM\String @ODM\Index(unique=true, order="asc")
     */
    private $username;

    /**
     * @ODM\String
     */
    private $password;

    /**
     * @ODM\String
     */
    private $salt;

    /**
     * @ODM\Hash
     */
    private $roles = array();

    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }
}
