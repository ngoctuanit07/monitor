<?php

namespace JohnNguyen\ServerMonitor\Manipulators;

use JohnNguyen\ServerMonitor\Models\Check;
use Symfony\Component\Process\Process;

class Passthrough implements Manipulator
{
    public function manipulateProcess(Process $process, Check $check): Process
    {
        return $process;
    }
}
