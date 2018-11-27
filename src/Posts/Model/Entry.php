<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 27.11.18
 * Time: 19:40
 */

namespace App\Posts\Model;

class Entry
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var EntryTemplate
     */
    private $template;

    public function __construct(int $id, EntryTemplate $template)
    {
        $this->id = $id;
        $this->template = $template;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return EntryTemplate
     */
    public function getTemplate(): EntryTemplate
    {
        return $this->template;
    }
}