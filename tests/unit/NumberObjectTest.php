<?php
namespace JClaveau;

use JClaveau\Exceptions\NotANumberException;
use JClaveau\Exceptions\NotStrictlyANumberException;

class NumberObjectTest extends \PHPUnit_Framework_TestCase
{
    public function throwsExceptionIfNotANumber(callable $call, $exceptionClass)
    {
        foreach (['lala', null, [], (object)[]] as $value) {
            try {
                $call( $value );
                $this->assertTrue(false, "no exception occured when '$exceptionClass' expected");
            }
            catch (\Exception $e) {
                $this->assertInstanceOf($exceptionClass, $e);
            }
        }
    }
    
    /**
     * NumberObject::new_ must never be called in a other test
     */
    public function test_new_()
    {
        foreach ([0.0, 0.1, -0.1, NAN, INF, 0, 1, -1, -0, 0x539, 0b10100111001, 1337e0] as $value) {
            $this->assertTrue( NumberObject::new_($value) instanceof NumberObject );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            NumberObject::new_($value);
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_Number_function()
    {
        foreach ([0.0, 0.1, -0.1, NAN, INF, 0, 1, -1, -0, 0x539, 0b10100111001, 1337e0] as $value) {
            $this->assertTrue( Number($value) instanceof NumberObject );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            Number($value);
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_isInteger()
    {
        foreach ([0, -0, 3, -3] as $value) {
            $this->assertTrue( Number($value)->isInteger() );
        }
        
        foreach ([0.0, -0.0, 0.1, -0.1, NAN, INF] as $value) {
            $this->assertFalse( Number($value)->isInteger() );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            Number($value)->isInteger();
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_isFloat()
    {
        foreach ([0.0, 0.1, NAN, INF] as $value) {
            $this->assertTrue( Number($value)->isFloat() );
        }
        
        foreach ([0, 1, -1, -0] as $value) {
            $this->assertFalse( Number($value)->isFloat() );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            Number($value)->isFloat();
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_isNan()
    {
        $this->assertTrue( Number(NAN)->isFloat() );
        
        foreach ([0, 1, -1, -0, 0.0, 0.1, INF] as $value) {
            $this->assertFalse( Number($value)->isNan() );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            Number($value)->isNan();
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_isInifinite()
    {
        foreach ([INF, -INF] as $value) {
            $this->assertTrue( Number($value)->isInfinite() );
        }
        
        foreach ([0, 1, -1, -0, 0.0, 0.1, -0.1, NAN] as $value) {
            $this->assertFalse( Number($value)->isInfinite() );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            Number($value)->isInfinite();
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_isPositive()
    {
        // foreach ([INF, -INF] as $value) {
        foreach ([INF, 0, 1, 0.0, 1.12, -0, -0.0] as $value) {
            $this->assertTrue( Number($value)->isPositive() );
        }
        
        foreach ([-INF, -1, -1.12] as $value) {
            $this->assertFalse( Number($value)->isPositive() );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            Number($value)->isPositive();
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_isNegative()
    {
        // foreach ([INF, -INF] as $value) {
        foreach ([INF, 0, 1, 0.0, 1.12, -0, -0.0] as $value) {
            $this->assertFalse( Number($value)->isNegative() );
        }
        
        foreach ([-INF, -1, -1.12] as $value) {
            $this->assertTrue( Number($value)->isNegative() );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            Number($value)->isNegative();
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_isEqualTo()
    {
        $cases = [INF, 0, 1, 0.0, 1.12, -0, -0.0, -INF, -1, -1.12];
        foreach ($cases as $case) {
            $this->assertTrue( Number($case)->isEqualTo($case) );
            $this->assertFalse( Number($case)->isEqualTo(-165.32) );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            Number($value)->isEqualTo($value);
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_isLowerThan()
    {
        $casesLower = [0.0, -0, 0, -0.0, -INF, -1, -1.12];
        foreach ($casesLower as $case) {
            // var_dump($case);
            $this->assertFalse( Number($case)->isLowerThan($case) );
            $this->assertTrue( Number($case)->isLowerThan(0.2) );
        }
        
        $casesGreater = [INF, 1, 1.12];
        foreach ($casesGreater as $case) {
            // var_dump($case);
            $this->assertFalse( Number($case)->isLowerThan($case) );
            $this->assertFalse( Number($case)->isLowerThan(0.2) );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            Number($value)->isLowerThan($value);
            
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_isGreaterThan()
    {
        $casesLower = [0.0, -0, 0, -0.0, -INF, -1, -1.12];
        foreach ($casesLower as $case) {
            // var_dump($case);
            $this->assertFalse( Number($case)->isGreaterThan($case) );
            $this->assertFalse( Number($case)->isGreaterThan(0.2) );
        }
        
        $casesGreater = [INF, 1, 1.12];
        foreach ($casesGreater as $case) {
            // var_dump($case);
            $this->assertFalse( Number($case)->isGreaterThan($case) );
            $this->assertTrue( Number($case)->isGreaterThan(0.2) );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            
            Number($value)->isGreaterThan($value);
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_isLowerOrEqualTo()
    {
        $casesLower = [0.0, -0, 0, -0.0, -INF, -1, -1.12];
        foreach ($casesLower as $case) {
            // var_dump($case);
            $this->assertTrue( Number($case)->isLowerOrEqualTo($case) );
            $this->assertFalse( Number($case)->isLowerOrEqualTo(0.2) );
        }
        
        $casesGreater = [INF, 1, 1.12];
        foreach ($casesGreater as $case) {
            // var_dump($case);
            $this->assertTrue( Number($case)->isLowerOrEqualTo($case) );
            $this->assertTrue( Number($case)->isLowerOrEqualTo(0.2) );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            
            Number($value)->isLowerOrEqualTo($value);
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_isGreaterOrEqualThan()
    {
        $casesLower = [0.0, -0, 0, -0.0, -INF, -1, -1.12];
        foreach ($casesLower as $case) {
            // var_dump($case);
            $this->assertTrue( Number($case)->isGreaterOrEqualTo($case) );
            $this->assertFalse( Number($case)->isGreaterOrEqualTo(0.2) );
        }
        
        $casesGreater = [INF, 1, 1.12];
        foreach ($casesGreater as $case) {
            // var_dump($case);
            $this->assertTrue( Number($case)->isGreaterOrEqualTo($case) );
            $this->assertTrue( Number($case)->isGreaterOrEqualTo(0.2) );
        }
        
        $this->throwsExceptionIfNotANumber(function($value) {
            
            Number($value)->isGreaterOrEqualTo($value);
        }, NotStrictlyANumberException::class);
    }

    /**
     */
    public function test_plus()
    {
        $this->assertTrue( Number(3)->plus(4)->isEqualTo(7) );
        $this->assertTrue( Number(-3)->plus(4)->isEqualTo(1) );
    }

    /**
     */
    public function test_minus()
    {
        $this->assertTrue( Number(3)->minus(4)->isEqualTo(-1) );
        $this->assertTrue( Number(-3)->minus(4)->isEqualTo(-7) );
    }

    /**
     */
    public function test_multipliedBy()
    {
        $this->assertTrue( Number(3)->multipliedBy(4)->isEqualTo(12) );
        $this->assertTrue( Number(-3)->multipliedBy(4)->isEqualTo(-12) );
    }

    /**
     */
    public function test_divideBy()
    {
        $this->assertTrue( Number(3)->dividedBy(4)->isEqualTo(.75) );
        $this->assertTrue( Number(-3)->dividedBy(4)->isEqualTo(-.75) );
    }

    /**
     */
    public function test_ceil()
    {
        $cases = [
            [0, 0],
            [0.1, 1],
            [-0.1, 0],
            [-1, -1],
            [INF, INF],
        ];
        
        foreach ($cases as $io) {
            $this->assertTrue( Number($io[0])->ceil()->isEqualTo($io[1]) );
        }
        
        $this->assertTrue( Number(NAN)->ceil()->isNan() );
    }

    /**/
}
