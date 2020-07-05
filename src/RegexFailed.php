<?php

namespace JohnNguyen\ServerMonitor;

use Exception;

class RegexFailed extends Exception
{
    public static function match(string $pattern, string $subject, string $message): self
    {
        $subject = static::trimString($subject);

        return new static("Error matching pattern `{$pattern}` with subject `{$subject}`. {$message}");
    }

    public static function replace(string $pattern, string $subject, string $message): self
    {
        $subject = static::trimString($subject);

        return new static("Error replacing pattern `{$pattern}` in subject `{$subject}`. {$message}");
    }

    public static function indexedGroupDoesntExist(string $pattern, string $subject, int $index): self
    {
        return new static("Pattern `{$pattern}` with subject `{$subject}` didn't capture a group at index {$index}");
    }

    public static function namedGroupDoesntExist(string $pattern, string $subject, string $groupName): self
    {
        return new static("Pattern `{$pattern}` with subject `{$subject}` didn't capture a group named {$groupName}");
    }

    protected static function trimString(string $string): string
    {
        if (strlen($string) < 40) {
            return $string;
        }

        return substr($string, 0, 40).'...';
    }
}
