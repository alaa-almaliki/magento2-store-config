<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Validators;

use Alaa\StoreConfig\Validators\FileExistsValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class FileExistsValidatorTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Validators
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class FileExistsValidatorTest extends TestCase
{
    /**
     * @var FileExistsValidator
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new FileExistsValidator();
    }

    public function testValidateShouldReturnTrue()
    {
        $root = dirname(dirname(__FILE__));
        $file = $root . '/_files/developer/default/default.php';
        $this->assertTrue($this->subject->validate($file));
    }

    public function testValidateShouldReturnFalse()
    {
        $file = '/unknow/path/_files/developer/default/default.php';
        $this->assertFalse($this->subject->validate($file));
    }
}