<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Validators;

use Alaa\StoreConfig\Validators\DeployModeValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class DeployModeValidatorTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Validators
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class DeployModeValidatorTest extends TestCase
{
    /**
     * @var DeployModeValidator
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new DeployModeValidator();
    }

    /**
     * @dataProvider getValidModesData
     */
    public function testValidateShouldReturnTrue($mode)
    {
        $this->assertTrue($this->subject->validate($mode));
    }

    public function testValidateShouldReturnFalse()
    {
        $this->assertFalse($this->subject->validate('default'));
    }


    public function getValidModesData()
    {
        return [
            ['developer'],
            ['production'],
        ];
    }
}