<?php

namespace Svnfqt\ProjectTrophies\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ODM\Document(repositoryClass="Svnfqt\ProjectTrophies\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
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

    /**
     * @ODM\String @ODM\Index(unique=true, order="asc")
     */
    private $email;

    /**
     * @ODM\ReferenceMany(targetDocument="Trophy", inversedBy="users", cascade={"persist"})
     */
    private $trophies;

    /**
     * @ODM\Timestamp
     * @Gedmo\Timestampable(on="create")
     */
    private $creationTimestamp;

    /**
     * @ODM\Timestamp
     * @Gedmo\Timestampable(on="update")
     */
    private $modificationTimestamp;

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

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTrophies()
    {
        return $this->trophies;
    }

    public function setCreationTimestamp($creationTimestamp)
    {
        $this->creationTimestamp = $creationTimestamp;
    }

    public function getCreationTimestamp()
    {
        return $this->creationTimestamp;
    }

    public function setModificationTimestamp($modificationTimestamp)
    {
        $this->modificationTimestamp = $modificationTimestamp;
    }

    public function getModificationTimestamp()
    {
        return $this->modificationTimestamp;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
            $this->username
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->username
        ) = unserialize($serialized);
    }
}
