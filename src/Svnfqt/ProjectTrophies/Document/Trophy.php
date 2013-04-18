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
     * @ODM\ReferenceOne(targetDocument="Image", cascade={"persist"})
     */
    private $image;

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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(Image $image)
    {
        $this->image = $image;
    }
}
