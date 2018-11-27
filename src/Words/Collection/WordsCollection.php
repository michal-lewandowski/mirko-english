<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 14.11.18
 * Time: 20:27
 */

namespace App\Words\Collection;

use App\Core\Collection\ObjectCollection;
use App\Words\Model\Word;
use Doctrine\Common\Collections\ArrayCollection;

class WordsCollection extends ObjectCollection
{
    public function __construct(array $elements = [])
    {
        parent::__construct(Word::class, $elements);
    }

    public static function createFromCSV(string $filePath)
    {
        $row = 1;
        $collection = new self();
        if (($handle = fopen($filePath, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                $num = count($data);
                $row++;
                for ($c=1; $c < $num; $c++) {
                    $word = Word::createFromArray($data);
                    $collection->add($word);
                }
            }
            fclose($handle);
        }
        return $collection;
    }

}