<?php
namespace JClaveau\Types;

/**
 * Interface ensuring the instance which implements it can be converted
 * to a boolean value
 */
interface Boolifiable
{
    public function toBool();
} 
