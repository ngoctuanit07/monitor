<?php

namespace JohnNguyen\ServerMonitor\Models\Presenters;

use Exception;
use JohnNguyen\ServerMonitor\Helpers\Emoji;

trait HostPresenter
{
    public function getHealthAsEmojiAttribute(): string
    {
        if ($this->isHealthy()) {
            return Emoji::ok();
        }

        if ($this->isUnhealthy()) {
            return Emoji::notOk();
        }

        if ($this->hasWarning()) {
            return Emoji::warning();
        }

        throw new Exception("Could not determine health emoji for host `{$this->id}`");
    }
}
