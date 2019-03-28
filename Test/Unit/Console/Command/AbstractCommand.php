<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Console\Command;

use PHPUnit\Framework\TestCase;
use Alaa\StoreConfig\Model\Config;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Class AbstractCommand
 *
 * @package Alaa\StoreConfig\Test\Unit\Console\Command
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
abstract class AbstractCommand extends TestCase
{
    use ConsoleMockTrait;

    /**
     * @var Config|MockObject
     */
    protected $config;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    protected function setUp()
    {
        parent::setUp();
        $this->config = $this->getConfigMock();
        $this->objectManager = new ObjectManager($this);
    }
}
