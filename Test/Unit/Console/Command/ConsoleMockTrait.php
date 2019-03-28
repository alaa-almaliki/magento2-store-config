<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Console\Command;

use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * Trait ConsoleMockTrait
 *
 * @package Alaa\StoreConfig\Test\Unit\Console\Command
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
trait ConsoleMockTrait
{
    use MockTrait;

    /**
     * @return MockObject|ArgvInput
     */
    public function getConsoleInputMock()
    {
        return $this->getMock(ArgvInput::class, ['parse']);
    }

    /**
     * @return MockObject|StreamOutput
     */
    public function getConsoleOutputMock()
    {
        return $this->getMock(StreamOutput::class);
    }
}