<?php

namespace JohnNguyen\ServerMonitor;

abstract class RegexResult
{
    protected static function lastPregError(): string
    {
        return array_flip(get_defined_constants(true)['pcre'])[preg_last_error()];
    }
}
