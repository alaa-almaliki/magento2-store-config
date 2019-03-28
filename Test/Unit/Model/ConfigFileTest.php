<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\ConfigFile;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigFileTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigFileTest extends TestCase
{
    public function testConfigFile()
    {
        $root = dirname(dirname(__FILE__));
        $data = [
            'root' => $root,
            'config_path' => '_files',
            'deploy_mode' => 'developer',
            'scope' => 'default',
            'code' => 'default'
        ];

        $configFile = new ConfigFile($data);
        $configurations = $configFile->getConfigurations();
        $this->assertEquals($root, $configFile->getRoot());
        $this->assertEquals('_files', $configFile->getConfigPath());
        $this->assertEquals('developer', $configFile->getDeployMode());
        $this->assertEquals('default', $configFile->getScope());
        $this->assertEquals('default', $configFile->getCode());

        $this->assertEquals($root . '/_files/developer/default/default.php', $configFile->getFile());
        $this->assertEquals([['path' => 'general/locale/code', 'value' => 'en_GB']], $configurations);
    }
}
