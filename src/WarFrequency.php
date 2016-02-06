<?php
/**
 * Holds the WarFrequency Enum/Interface
 */
namespace COCUrl;

/**
 * Interface to emulate an Enum for the choices in the clans request for the
 * war frequency
 */
interface WarFrequency
{
    const ALWAYS                  = 'always';
    const MORE_THAN_ONCE_PER_WEEK = 'moreThanOncePerWeek';
    const ONCE_PER_WEEK           = 'oncePerWeek';
    const LESS_THAN_ONCE_PER_WEEK = 'lessThanOncePerWeek';
    const NEVER                   = 'never';
    const UNKNOWN                 = 'unknown';
}
