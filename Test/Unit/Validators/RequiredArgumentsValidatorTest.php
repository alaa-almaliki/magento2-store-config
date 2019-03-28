<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Validators;

use Alaa\StoreConfig\Validators\RequiredArgumentsValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class RequiredArgumentsValidatorTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Validators
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class RequiredArgumentsValidatorTest extends TestCase
{
    /**
     * @var RequiredArgumentsValidator
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new RequiredArgumentsValidator([
            'path',
            'value'
        ]);
    }

    public function testValidateShouldReturnTrue()
    {
        $this->assertTrue($this->subject->validate([
            'path' => 'xml/path/1',
            'value' => 1,
        ]));
    }

    public function testValidateShouldReturnFalse()
    {
        $this->assertFalse($this->subject->validate([
            'path' => 'xml/path/1',
        ]));
    }
}