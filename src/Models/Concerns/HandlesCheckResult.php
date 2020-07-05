<?php

namespace JohnNguyen\ServerMonitor\Models\Concerns;

use JohnNguyen\ServerMonitor\Events\CheckFailed;
use JohnNguyen\ServerMonitor\Events\CheckWarning;
use JohnNguyen\ServerMonitor\Events\CheckSucceeded;
use JohnNguyen\ServerMonitor\Helpers\ConsoleOutput;
use JohnNguyen\ServerMonitor\Models\Enums\CheckStatus;

trait HandlesCheckResult
{
    public function succeed(string $message = '')
    {
        $this->status = CheckStatus::SUCCESS;
        $this->last_run_message = $message;

        $this->save();

        event(new CheckSucceeded($this));
        ConsoleOutput::info($this->host->name.": check `{$this->type}` succeeded");

        return $this;
    }

    public function warn(string $warningMessage = '')
    {
        $this->status = CheckStatus::WARNING;
        $this->last_run_message = $warningMessage;

        $this->save();

        event(new CheckWarning($this));

        ConsoleOutput::info($this->host->name.": check `{$this->type}` issued warning");

        return $this;
    }

    public function fail(string $failureReason = '')
    {
        $this->status = CheckStatus::FAILED;
        $this->last_run_message = $failureReason;

        $this->save();

        event(new CheckFailed($this));

        ConsoleOutput::error($this->host->name.": check `{$this->type}` failed");

        return $this;
    }
}
