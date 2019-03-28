<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\Catchable;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class CatchableTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class CatchableTest extends TestCase
{
    public function testCatchShouldReturnValue()
    {
        $catchable = new Catchable();
        $value = $catchable->catch(function () {
            return 1;
        });
        $arrayValue = $catchable->catch(function () {
            throw new Exception();
        }, []);

        $this->assertEquals(1, $value);
        $this->assertTrue(is_array($arrayValue));
        $this->assertEmpty($arrayValue);
    }

    public function testCatchShouldReturnNull()
    {
        $catchable = new Catchable();
        $value = $catchable->catch(function () {
            throw new Exception();
        });

        $this->assertNull($value);
    }
}