<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Validators;

/**
 * Class FileExistsValidator
 *
 * @package Alaa\StoreConfig\Validators
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class FileExistsValidator
{
    /**
     * @param string $file
     * @return bool
     */
    public function validate(string $file): bool
    {
        return file_exists($file) && is_file($file);
    }
}
