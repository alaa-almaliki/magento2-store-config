<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\ConfigFile;
use Alaa\StoreConfig\Model\StoreScopeId;

/**
 * Class StoreScopeIdTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class StoreScopeIdTest extends AbstractScopeId
{
    /**
     * @var StoreScopeId
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->objectManager->getObject(StoreScopeId::class, [
           'storeManager' => $this->storeManager,
            'catchable' => $this->catchable
        ]);
    }

    public function testGetScopeIdShouldReturnScopeId()
    {
        $this->assertEquals(1, $this->subject->getScopeId(new ConfigFile(['code' => 'default'])));
    }

    public function testGetScopeIdShouldReturnNull()
    {
        $this->storeManager->expects($this->any())
            ->method('getStore')
            ->willThrowException(new \Exception('store exception'));
        $this->assertNull($this->subject->getScopeId(new ConfigFile(['code' => 'default'])));
    }
}