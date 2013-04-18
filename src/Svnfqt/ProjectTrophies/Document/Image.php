<?php

namespace Svnfqt\ProjectTrophies\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
class Image
{
    /**
     * @ODM\Id
     */
    private $id;

    /**
     * @ODM\Field
     */
    private $filename;

    /**
     * @ODM\File
     */
    private $file;

    public function getId()
    {
        return $this->id;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $file = (string) $file; // FIXME Bug : cast to string should be done automatically by odm
        $this->file = $file;
    }
}
