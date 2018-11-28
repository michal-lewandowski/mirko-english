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
    private $className;

    public function __construct(string $className, array $elements = [])
    {
        parent::__construct($elements);
        $this->className = $className;
    }

    public function add($element)
    {
        if (false === $element instanceof $this->className) {
            throw new \InvalidArgumentException(sprintf(
                'Element must be instance of %s',$this->className
            ));
        }
        parent::add($element);
    }
}