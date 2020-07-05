<?php

namespace JohnNguyen\ServerMonitor\CheckDefinitions;

use Symfony\Component\Process\Process;

final class Memcached extends CheckDefinition
{
    public $command = 'service memcached status';

    public function resolve(Process $process)
    {
        if (str_contains($process->getOutput(), 'memcached is running')) {
            $this->check->succeed('is running');

            return;
        }

        $this->check->fail('is not running');
    }
}
