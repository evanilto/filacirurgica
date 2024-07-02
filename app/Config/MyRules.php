<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Validation\StrictRules\MyRules;

use DateTime;

/**
 * Format validation Rules.
 */
class MyRules
{
    /**
     * Checks for a valid date and matches a given date format and greater than today
     */
    public function valid_date(?string $str = null, ?string $format = null): bool
    {
        if (empty($format)) {
            return strtotime($str) !== false;
        }

        $date   = DateTime::createFromFormat($format, $str);
        $errors = DateTime::getLastErrors();

        return $date !== false && $errors !== false && $errors['warning_count'] === 0 && $errors['error_count'] === 0;
    }
}
