<?php

namespace JohnNguyen\ServerMonitor\Events;

use JohnNguyen\ServerMonitor\Models\Check;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class Event implements ShouldQueue
{
    /** @var \JohnNguyen\ServerMonitor\Check */
    public $check;

    public function __construct(Check $check)
    {
        $this->check = $check;
    }
}
