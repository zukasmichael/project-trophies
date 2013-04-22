<?php

namespace Svnfqt\ProjectTrophies\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(repositoryClass="Svnfqt\ProjectTrophies\Repository\TrophyRepository")
 */
class Trophy
{
    /**
     * @ODM\Id
     */
    private $id;

    /**
     * @ODM\String @ODM\Index(unique=true, order="asc")
     */
    private $name;

    /**
     * @ODM\String
     */
    private $description;

    /**
     * @ODM\ReferenceOne(targetDocument="Image", cascade={"persist"})
     */
    private $image;

    /**
     * @ODM\ReferenceMany(targetDocument="User", mappedBy="trophies")
     */
    private $users;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(Image $image)
    {
        $this->image = $image;
    }

    public function getUsers()
    {
        return $this->users;
    }
}
