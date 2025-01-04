<?php

namespace App\Http\Controllers;

use RouterOS\Client;
use RouterOS\Query;
use App\Models\Router;
use phpseclib3\Net\SSH2;
use Illuminate\Support\Facades\Crypt;
class Log extends Controller
{
    public function __invoke($log)
    {
        $router = Router::where("id", $log)->firstOrFail();

        try {
            $ssh = new SSH2('202.61.110.158', 700);

            // Attempt SSH login
            if (!$ssh->login('longlong', 'admin12345')) {
                throw new \Exception('Login failed');
            }

            // Execute the command
            $result = $ssh->exec('/log print');

            // Ensure the result is a valid string
            if (!is_string($result) || empty($result)) {
                throw new \Exception('SSH command returned invalid output.');
            }

            // Parse the log output
            $logs = $this->parseLogOutput($result);
        } catch (\Exception $e) {
            report($e);
            return back()->with("error", __("Failed to connect to Mikrotik. Please check your credentials or connection."));
        }

        return view('log', compact('logs'));
    }

    /**
     * Parse the SSH command output into a structured array of log entries.
     *
     * @param string $output The raw SSH command output.
     * @return array Parsed logs.
     */
    private function parseLogOutput($output)
    {
        // Ensure the output is a string
        if (!is_string($output)) {
            throw new \InvalidArgumentException('Output is not a valid string.');
        }

        // Debugging: Log the raw output
        \Log::info("Raw SSH Output: " . print_r($output, true));

        // Split output into lines and filter out empty ones
        $lines = array_filter(explode("\n", $output));

        $logs = [];


        return $logs;
    }
}
