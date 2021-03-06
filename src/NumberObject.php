<?php
namespace JClaveau;

use JClaveau\Exceptions\NotANumberException;
use JClaveau\Contracts\Numberifiable;

/**
 * NumberObject
 * 
 * @todo isResource()
 * @todo format()
 * 
 * @see https://secure.php.net/manual/fr/ref.math.php
 */
class NumberObject extends Type implements Numberifiable
{
    protected $nanable = true;
    protected $nanReason;
    
    /**
     * @todo $options mutable
     * @todo $options nanable
     */
    public static function new_($value, $options=[])
    {
        if ($value instanceof static) {
            return $value;
        }
        
        return new static(Types::toNumber($value));
    }

    /**
     * Return the native value of the NumberObject
     */
    public function toNativeNumber()
    {
        return Numbers::toNativeNumber($this->getValue());
    }
    
    
    /**
     * Checks if the value is integer
     */
    public function isInteger()
    {
        return Numbers::isInteger($this->getValue());
    }
    
    /**
     * Checks if the value is float
     */
    public function isFloat()
    {
        return Numbers::isFloat($this->getValue());
    }
    
    /**
     * Checks if the value is Nan
     */
    public function isNan()
    {
        return Numbers::isNan($this->getValue());
    }
    
    /**
     * Checks if the value is Nan
     */
    public function isInfinite()
    {
        return Numbers::isInfinite($this->getValue());
    }
    
    /**
     * Checks if the value is positive
     */
    public function isPositive()
    {
        return Numbers::isPositive($this->getValue());
    }
    
    /**
     * Checks if the value is negative
     */
    public function isNegative()
    {
        return Numbers::isNegative($this->getValue());
    }
    
    /**
     * Checks if the value of the current instance is greater than the
     * parameter
     * 
     * @param  int|float|Numberifiable $valueToCompare
     * @return bool
     */
    public function isGreaterThan($valueToCompare)
    {
        return Numbers::isGreaterThan($this->getValue(), $valueToCompare);
    }
    
    /**
     * Checks if the value is equal to the parameter
     * 
     * @param  int|float|Numberifiable $valueToCompare
     * @return bool
     */
    public function isEqualTo($valueToCompare)
    {
        return Numbers::areEqual($this->getValue(), $valueToCompare);
    }
    
    /**
     * Checks if the value of the current instance is lower than the
     * parameter
     * 
     * @param  int|float|Numberifiable $valueToCompare
     * @return bool
     */
    public function isLowerThan($valueToCompare)
    {
        return Numbers::isLowerThan($this->getValue(), $valueToCompare);
    }
    
    /**
     * Checks if the value of the current instance is greater than the
     * parameter
     * 
     * @param  int|float|Numberifiable $valueToCompare
     * @return bool
     */
    public function isGreaterOrEqualTo($valueToCompare)
    {
        return Numbers::isGreaterOrEqualTo($this->getValue(), $valueToCompare);
    }
    
    /**
     * Checks if the value of the current instance is lower or equal to 
     * the parameter
     * 
     * @param  int|float|Numberifiable $valueToCompare
     * @return bool
     */
    public function isLowerOrEqualTo($valueToCompare)
    {
        return Numbers::isLowerOrEqualTo($this->getValue(), $valueToCompare);
    }
    
    /**
     */
    public function plus($value)
    {
        if ($this->callOnCloneIfImmutable($result)) {
            return $result;
        }
        
        $this->setValue( Numbers::add($this->getValue(), $value) );
        return $this;
    }
    
    /**
     */
    public function minus($value)
    {
        if ($this->callOnCloneIfImmutable($result)) {
            return $result;
        }
        
        $this->setValue( Numbers::substract($this->getValue(), $value) );
        return $this;
    }
    
    /**
     */
    public function multipliedBy($value)
    {
        if ($this->callOnCloneIfImmutable($result)) {
            return $result;
        }
        
        $this->setValue( Numbers::multiply($this->getValue(), $value) );
        return $this;
    }
    
    /**
     */
    public function dividedBy($value)
    {
        if ($this->callOnCloneIfImmutable($result)) {
            return $result;
        }
        
        $this->setValue( Numbers::divide($this->getValue(), $value) );
        return $this;
    }
    
    
    // MATHS https://secure.php.net/manual/fr/ref.math.php
    
    // ceil()
    // round()
    // floor()
    // add()
    // sub()
    // div()
    // times()
    // pow()
    // sqrt()
    // rand()
    // cos()
    // sin()
    // tan()
    
    /**
     */
    public function ceil()
    {
        if ($this->callOnCloneIfImmutable($result)) {
            return $result;
        }
        $this->setValue( Numbers::ceil($this->getValue()) );
        return $this;
    }
    
    /**
     */
    public function round()
    {
        if ($this->callOnCloneIfImmutable($result)) {
            return $result;
        }
        return Numbers::round($this->getValue());
    }
    
    /**
     */
    public function floor()
    {
        if ($this->callOnCloneIfImmutable($result)) {
            return $result;
        }
        return Numbers::floor($this->getValue());
    }
    
    /**
     */
    public function random()
    {
        if ($this->callOnCloneIfImmutable($result)) {
            return $result;
        }
        return Numbers::rand($this->getValue());
    }
    
    /**
     */
    public function power($exp)
    {
        assert(Types::isNumber($exp));
        if ($this->callOnCloneIfImmutable($result)) {
            return $result;
        }
        return Numbers::pow($this->getValue(), $exp);
    }
    
    /**
     */
    public function squareRoot()
    {
        if ($this->callOnCloneIfImmutable($result)) {
            return $result;
        }
        return Numbers::sqrt($this->getValue());
    }
    
    /**/
} 
