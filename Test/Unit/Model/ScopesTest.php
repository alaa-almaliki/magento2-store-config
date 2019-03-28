<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;
use Alaa\StoreConfig\Model\ConfigFile;
use Alaa\StoreConfig\Model\Scopes;
use PHPUnit\Framework\TestCase;

/**
 * Class ScopesTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ScopesTest extends TestCase
{
    public function testGetScopeIdShouldReturnDefaultScopeId()
    {
        $scopes = new Scopes([]);
        $this->assertEquals(Scopes::DEFAULT_STORE_ID, $scopes->getScopeId(new ConfigFile(['scope' => 'default'])));
    }

    public function testGetScopeIdShouldReturnStoresScopeId()
    {
        $scopes = new Scopes([
            'stores' => new class() {
                public function getScopeId(ConfigFileInterface $configFile): int
                {
                    return 1;
                }
            }
        ]);
        $this->assertEquals(1, $scopes->getScopeId(new ConfigFile(['scope' => 'stores'])));
    }

    public function testGetScopeIdShouldReturnWebsitesScopeId()
    {
        $scopes = new Scopes([
            'websites' => new class() {
                public function getScopeId(ConfigFileInterface $configFile): int
                {
                    return 1;
                }
            }
        ]);
        $this->assertEquals(1, $scopes->getScopeId(new ConfigFile(['scope' => 'websites'])));
    }
}