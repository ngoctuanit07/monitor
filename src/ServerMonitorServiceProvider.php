<?php

namespace JohnNguyen\ServerMonitor;

use Illuminate\Support\ServiceProvider;
use JohnNguyen\ServerMonitor\Commands\AddHost;
use JohnNguyen\ServerMonitor\Commands\SyncFile;
use JohnNguyen\ServerMonitor\Commands\ListHosts;
use JohnNguyen\ServerMonitor\Commands\RunChecks;
use JohnNguyen\ServerMonitor\Commands\DeleteHost;
use JohnNguyen\ServerMonitor\Commands\ListChecks;
use JohnNguyen\ServerMonitor\Manipulators\Manipulator;
use JohnNguyen\ServerMonitor\Notifications\EventHandler;
class ServerMonitorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/server-monitor.php' => config_path('server-monitor.php'),
            ], 'config');

            $this->publishesMigration('CreateHostsTable', 'create_hosts_table', 1);
            $this->publishesMigration('CreateChecksTable', 'create_checks_table', 2);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/server-monitor.php', 'server-monitor');

        $this->app->bind(Manipulator::class, config('server-monitor.process_manipulator'));

        $this->app['events']->subscribe(EventHandler::class);

        $this->app->bind('command.server-monitor:run-checks', RunChecks::class);
        $this->app->bind('command.server-monitor:add-host', AddHost::class);
        $this->app->bind('command.server-monitor:delete-host', DeleteHost::class);
        $this->app->bind('command.server-monitor:sync-file', SyncFile::class);
        $this->app->bind('command.server-monitor:list', ListHosts::class);
        $this->app->bind('command.server-monitor:list-checks', ListChecks::class);

        $this->commands([
            'command.server-monitor:run-checks',
            'command.server-monitor:add-host',
            'command.server-monitor:delete-host',
            'command.server-monitor:sync-file',
            'command.server-monitor:list',
            'command.server-monitor:list-checks',
        ]);
    }

    protected function publishesMigration(string $className, string $fileName, int $timestampSuffix)
    {
        if (!class_exists($className)) {
            $timestamp = date('Y_m_d_His', time()) . $timestampSuffix;

            $this->publishes([
                __DIR__ . "/../database/migrations/{$fileName}.php.stub" => database_path('migrations/' . $timestamp . "_{$fileName}.php"),
            ], 'migrations');
        }
    }
}
