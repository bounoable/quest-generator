<?php

namespace Bounoable\Quest\Support;

trait ValidatesScalarData
{
    /**
     * Check if an array only contains scalar values.
     */
    public function validate(array $data): bool
    {
        foreach ($data as $value) {
            if (is_array($value) && !$this->validate($value)) {
                return false;
            }

            if (!is_scalar($value)) {
                return false;
            }
        }

        return true;
    }
}
