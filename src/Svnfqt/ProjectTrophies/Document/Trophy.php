<?php

namespace Svnfqt\ProjectTrophies\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

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

    public function getId()
    {
        return $this->id;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        return $this->slug;
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
}
