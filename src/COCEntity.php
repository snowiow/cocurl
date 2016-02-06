<?php
/**
 * Holds COCEntity Class
 */
namespace COCUrl;

/**
 * An abstract class, which is the base class for all the coc api data
 * containers.
 */
abstract class COCEntity
{
    /**
     * Fills the data from an array into the given class
     * @param array     $data   the data which will be filled into the class
     * @param COCEntity $entity the cocentity child which need to be filled
     * @return void
     */
    public static function fill(array $data, COCEntity &$entity)
    {
        $vars = get_object_vars($entity);
        foreach ($vars as $var => $_) {
            if (array_key_exists($var, $data)) {
                $entity->{$var} = $data[$var];
            }
        }
    }

    /**
     * Creates a COCEntity child object with the given data. Needs to be
     * implemented by each child class. Normally just consists of creating the
     * class itself and call the fill method of the base class.
     * @param array $data an associative array to fill up the members of the
     * cocentity class
     * @return a cocentity object with the data given as it's members
     */
    abstract public static function create(array $data);
}
