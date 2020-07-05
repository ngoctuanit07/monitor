<?php

namespace JohnNguyen\ServerMonitor;

use Exception;

class MatchResult extends RegexResult
{
    /** @var string */
    protected $pattern;

    /** @var string */
    protected $subject;

    /** @var bool */
    protected $hasMatch;

    /** @var array */
    protected $matches;

    public function __construct(string $pattern, string $subject, bool $hasMatch, array $matches)
    {
        $this->pattern = $pattern;
        $this->subject = $subject;
        $this->hasMatch = $hasMatch;
        $this->matches = $matches;
    }

    /**
     * @param string $pattern
     * @param string $subject
     *
     * @return static
     *
     * @throws \JohnNguyen\Regex\RegexFailed
     */
    public static function for(string $pattern, string $subject)
    {
        $matches = [];

        try {
            $result = preg_match($pattern, $subject, $matches);
        } catch (Exception $exception) {
            throw RegexFailed::match($pattern, $subject, $exception->getMessage());
        }

        if ($result === false) {
            throw RegexFailed::match($pattern, $subject, static::lastPregError());
        }

        return new static($pattern, $subject, $result, $matches);
    }

    public function hasMatch(): bool
    {
        return $this->hasMatch;
    }

    /**
     * @return string|null
     */
    public function result()
    {
        return $this->matches[0] ?? null;
    }

    /**
     * Match group by index.
     *
     * @param int $index
     *
     * @return string
     *
     * @throws RegexFailed
     */
    public function group(int $index): string
    {
        if (! isset($this->matches[$index])) {
            throw RegexFailed::indexedGroupDoesntExist($this->pattern, $this->subject, $index);
        }

        return $this->matches[$index];
    }

    /**
     * Match group by name.
     *
     * @param string $groupName
     *
     * @return string
     *
     * @throws RegexFailed
     */
    public function namedGroup(string $groupName): string
    {
        if (! isset($this->matches[$groupName])) {
            throw RegexFailed::namedGroupDoesntExist($this->pattern, $this->subject, $groupName);
        }

        return $this->matches[$groupName];
    }
}
