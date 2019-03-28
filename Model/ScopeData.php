<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Model\Api\ScopeInterface;
use Alaa\StoreConfig\Validators\SensitivePathValidator;

/**
 * Class ScopeData
 *
 * @package Alaa\StoreConfig\Model\Setup
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ScopeData implements ScopeInterface
{
    /**
     * @var CoreData
     */
    protected $coreData;

    /**
     * @var SensitivePathValidator
     */
    protected $sensitivePathValidator;

    /**
     * @var array
     */
    protected $scopeData = [];

    /**
     * ScopeData constructor.
     *
     * @param CoreData $coreData
     * @param SensitivePathValidator $sensitivePathValidator
     */
    public function __construct(CoreData $coreData, SensitivePathValidator $sensitivePathValidator)
    {
        $this->coreData = $coreData;
        $this->sensitivePathValidator = $sensitivePathValidator;
    }

    /**
     * @return array
     */
    public function getScopeData(): array
    {
        if (empty($this->scopeData)) {
            $coreData = $this->coreData->getData();
            foreach ($this->getScopes() as $scope) {
                $filtered = array_filter($coreData, function (array $data, $idx) use ($scope, &$coreData) {
                    $matched = (bool) \in_array($scope, $data) && $this->sensitivePathValidator->validate($data);
                    if (\in_array($scope, $data)) {
                        unset($coreData[$idx]);
                    }
                    return $matched;
                }, ARRAY_FILTER_USE_BOTH);

                $this->scopeData[$scope] = array_values($filtered);
            }
        }

        return $this->scopeData;
    }

    /**
     * @return array
     */
    public function getScopes(): array
    {
        return [
            self::STORE_CONFIG_SCOPE_DEFAULT,
            self::STORE_CONFIG_SCOPE_WEBSITES,
            self::STORE_CONFIG_SCOPE_STORES
        ];
    }
}
