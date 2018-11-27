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

    public function __construct(string $template)
    {
        $this->template = $template;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function __toString()
    {
        return $this->template;
    }
}