<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;
use Alaa\StoreConfig\Model\Api\ScopeConfigGeneratorInterface;
use Magento\Framework\Filesystem\Io\File;
use Zend\Code\Generator\ValueGenerator;
use Zend\Code\Generator\ValueGeneratorFactory;

/**
 * Class ScopeConfigGenerator
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ScopeConfigGenerator implements ScopeConfigGeneratorInterface
{
    /**
     * @var File
     */
    protected $fileAdapter;

    /**
     * @var ValueGeneratorFactory
     */
    protected $valueGeneratorFactory;

    /**
     * ScopeConfigGenerator constructor.
     *
     * @param File $fileAdapter
     * @param ValueGeneratorFactory $valueGeneratorFactory
     */
    public function __construct(File $fileAdapter, ValueGeneratorFactory $valueGeneratorFactory)
    {
        $this->fileAdapter = $fileAdapter;
        $this->valueGeneratorFactory = $valueGeneratorFactory;
    }

    /**
     * @param ConfigFileInterface $configFile
     * @param array $scopeData
     * @return void
     */
    public function generate(ConfigFileInterface $configFile, array $scopeData)
    {
        $file = $configFile->getFile();
        $this->fileAdapter->mkdir(dirname($file), 0755);
        $valueGenerator = $this->valueGeneratorFactory->create([
            'value' => array_values($this->getFilteredData($scopeData)),
            'type' => ValueGenerator::TYPE_ARRAY_SHORT
        ]);
        $this->fileAdapter->write(
            $file,
            "<?php\n\ndeclare(strict_types=1);\n\nreturn " . $valueGenerator->generate() . ";\n"
        );
        $this->fileAdapter->chmod($file, 0664);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function getFilteredData(array $data): array
    {
        return \array_map(function (array $item) {
            return [
                'path' => $item['path'],
                'value' => $item['value'],
            ];
        }, $data);
    }
}
