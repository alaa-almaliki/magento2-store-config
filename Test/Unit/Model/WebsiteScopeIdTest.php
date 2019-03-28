<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\ConfigFile;
use Alaa\StoreConfig\Model\WebsiteScopeId;

/**
 * Class WebsiteScopeIdTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class WebsiteScopeIdTest extends AbstractScopeId
{
    /**
     * @var WebsiteScopeId
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->objectManager->getObject(WebsiteScopeId::class, [
            'storeManager' => $this->storeManager,
            'catchable' => $this->catchable
        ]);
    }

    public function testGetScopeIdShouldReturnScopeId()
    {
        $this->assertEquals(1, $this->subject->getScopeId(new ConfigFile(['code' => 'base'])));
    }

    public function testGetScopeIdShouldReturnNull()
    {
        $this->storeManager->expects($this->any())
            ->method('getWebsite')
            ->willThrowException(new \Exception('store exception'));
        $this->assertNull($this->subject->getScopeId(new ConfigFile(['code' => 'base'])));
    }
}