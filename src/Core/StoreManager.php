<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 27.11.18
 * Time: 20:16
 */

namespace App\Core;


class StoreManager
{
    /**
     * @var string
     */
    private $storeFilePath;

    public function __construct(string $storeFilePath)
    {
        $this->storeFilePath = $storeFilePath;
    }

    public function getPostId(): int
    {
        return (int) file_get_contents($this->storeFilePath);
    }

    public function setPostId(int $postId): void
    {
        file_put_contents($this->storeFilePath, $postId);

    }
}