<?php

namespace App\Http\Controllers;

use RouterOS\Client;
use RouterOS\Query;
use App\Models\Router;

use Illuminate\Http\Request;
use phpseclib3\Net\SSH2;

class MikData extends Controller
{
    public function __invoke($log)
    {
        $router = Router::where("id", $log)->firstOrFail();

        try {
            $ssh = new SSH2($router->ip);

            if (!$ssh->login($router->username, $router->password)) {
                throw new \Exception("SSH login failed");
            }

            // Run the command to retrieve logs
            $logsOutput = $ssh->exec('/log print');

            // Parse logs into structured data
            $logs = [];
            $logLines = explode("\n", trim($logsOutput));

            foreach ($logLines as $line) {
                // Assume log line structure: "time topics message"
                if (preg_match('/^(\S+)\s+(\S+)\s+(.+)$/', $line, $matches)) {
                    $logs[] = [
                        'time' => $matches[1],
                        'topics' => $matches[2],
                        'message' => $matches[3],
                    ];
                }
            }
        } catch (\Exception $e) {
            return back()->with("error", __("Mikrotik connection failed: " . $e->getMessage()));
        }

        return view('log', compact('logs'));
    }
}
