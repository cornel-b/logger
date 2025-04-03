<?php

namespace App\Logging;

use App\Models\AppLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;

class DatabaseLogHandler extends AbstractProcessingHandler
{
    public function __construct($level = Logger::DEBUG)
    {
        parent::__construct($level);
    }

    protected function write(LogRecord $record): void
    {
        $request = request();
        $route = $request->route();

        $routeName = $route ? $route->getName() : null;
        $routeUrl = $request->fullUrl();
        $routePath = $request->path();
        $routeMethod = $request->method();
        $routeParams = [
            'query' => $request->query(),
            'request' => $request->all(),
            'input' => $request->input(),
        ];

        $recordArray = $record->toArray();

        if (isset($recordArray['context']['exception']) && $recordArray['context']['exception'] instanceof \Throwable) {
            $exception = $recordArray['context']['exception'];
            $stackTrace = $exception->getTraceAsString();
        } else {
            $stackTrace = $recordArray['message']."\n".json_encode($recordArray['context'], JSON_PRETTY_PRINT);
        }

        $dbConnections = $this->getActiveConnections();

        AppLog::create([
            'stack_trace' => $stackTrace,
            'verbosity_level' => strtolower($recordArray['level_name']),
            'route_name' => $routeName,
            'route_url' => $routeUrl,
            'route_path' => $routePath,
            'route_method' => $routeMethod,
            'route_params' => $routeParams,
            'user_id' => Auth::id(),
            'db_connections' => $dbConnections,
        ]);
    }

    protected function getActiveConnections(): array
    {
        $dbConnections = [];

        $defaultConnection = Config::get('database.default');

        $connections = DB::getConnections();

        // If no connections are active, get at least the default
        if (empty($connections)) {
            $connection = Config::get('database.connections.'.$defaultConnection);
            if (isset($connection['database'])) {
                $dbConnections[$defaultConnection] = $connection['database'];
            }
        } else {
            foreach ($connections as $name => $connection) {
                try {
                    $config = $connection->getConfig();
                    if (isset($config['database'])) {
                        $dbConnections[$name] = $config['database'];
                    }
                } catch (\Exception $e) {
                    $configConnection = Config::get('database.connections.'.$name);
                    if (isset($configConnection['database'])) {
                        $dbConnections[$name] = $configConnection['database'];
                    }
                }
            }
        }

        return $dbConnections;
    }
}
