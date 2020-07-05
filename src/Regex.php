<?php

namespace JohnNguyen\ServerMonitor;

class Regex
{
    /**
     * @param string $pattern
     * @param string $subject
     *
     * @return \JohnNguyen\Regex\MatchResult
     */
    public static function match(string $pattern, string $subject): MatchResult
    {
        return MatchResult::for($pattern, $subject);
    }

    /**
     * @param string $pattern
     * @param string $subject
     *
     * @return \JohnNguyen\Regex\MatchAllResult
     */
    public static function matchAll(string $pattern, string $subject): MatchAllResult
    {
        return MatchAllResult::for($pattern, $subject);
    }

    /**
     * @param string|array $pattern
     * @param string|array|callable $replacement
     * @param string|array $subject
     * @param int $limit
     *
     * @return \JohnNguyen\Regex\ReplaceResult
     */
    public static function replace($pattern, $replacement, $subject, $limit = -1): ReplaceResult
    {
        return ReplaceResult::for($pattern, $replacement, $subject, $limit);
    }
}
