<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 27.11.18
 * Time: 19:42
 */

namespace App\Posts\Model;


class EntryTemplate
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $attachedImage;


    public function __construct(string $template, string $attachedImage)
    {
        $this->template = $template;
        $this->attachedImage = $attachedImage;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @return string
     */
    public function getAttachedImage()
    {
        return $this->attachedImage;
    }

    public function __toString()
    {
        return $this->template;
    }
}
