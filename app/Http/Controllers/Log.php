<?php

namespace App\Http\Controllers;

use RouterOS\Client;
use RouterOS\Query;
use App\Models\Router;

use Illuminate\Http\Request;
use phpseclib3\Net\SSH2;

class Log extends Controller
{
    public function __invoke($log)
    {
        $router = Router::where("id", $log)->firstOrFail();

        try {
            $ssh = new SSH2($router->ip);

            if (!$ssh->login($router->username, $router->password)) {
                throw new \Exception("SSH login failed");
            }

            // Get system resource info (includes uptime)
            $systemResources = $ssh->exec('/system resource print');

            // Get profile information
            $profiles = $ssh->exec('/ip hotspot user profile print');

            // Get last logged-out timestamp and remote address (check logs for 'logout' events)
            $logData = $ssh->exec('/log print where message~"logout"');

            // Parse uptime
            $uptime = '';
            if (preg_match('/uptime: (.+?)(?=\n|$)/', $systemResources, $matches)) {
                $uptime = trim($matches[1]);
            }

            // Parse profiles into structured data
            $profileData = [];
            $profileLines = explode("\n", trim($profiles));
            foreach ($profileLines as $line) {
                if (preg_match('/^\s*\d+\s+(\S+)\s+(.+)$/', $line, $matches)) {
                    $profileData[] = [
                        'name' => trim($matches[1]),
                        'settings' => trim($matches[2])
                    ];
                }
            }

            // Parse the last logged-out entry and remote address
            $lastLoggedOut = '';
            $remoteAddress = '';
            if (preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\s+.*logout.*from\s+(\d+\.\d+\.\d+\.\d+)/', $logData, $matches)) {
                $lastLoggedOut = trim($matches[1]);
                $remoteAddress = trim($matches[2]);
            }

            // Structure the data
            $data = [
                'uptime' => $uptime,
                'profiles' => $profileData,
                'router' => [
                    'ip' => $router->ip,
                    'name' => $router->name ?? 'Unknown'
                ],
                'lastLoggedOut' => $lastLoggedOut,
                'remoteAddress' => $remoteAddress
            ];

            // Debug output
            dd($data);

        } catch (\Exception $e) {
            return back()->with("error", __("Mikrotik connection failed: " . $e->getMessage()));
        }

        return view('log', compact('data'));
    }
}
