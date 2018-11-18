<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 14.11.18
 * Time: 19:46
 */

namespace App\Core\Collection;

use Doctrine\Common\Collections\ArrayCollection;

class ObjectCollection extends ArrayCollection
{
    /**
     * @var string
     */
    private $object;

    public function __construct(string $object, array $elements = [])
    {
        parent::__construct($elements);
        $this->object = $object;
    }

    public function add($element)
    {
        if (false === $element instanceof $this->object) {
            throw new \InvalidArgumentException(sprintf(
                'Element must be instance of %s',$this->object
            ));
        }
        parent::add($element);
    }
}