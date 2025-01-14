<?php

namespace App\Http\Controllers;

use App\Models\MikrotikParamter;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Router;
use RouterOS\Client;
use RouterOS\Query;
class UserRefresh extends Controller
{
    public function __invoke(User $user)
    {
        $router_name = $user->detail->router_name;
        dd($router_name);
        $router = Router::where("name", $router_name)->firstOrFail();

        try {
            $client = new Client([
                "host" => $router->ip,
                "user" => $router->username,
                "pass" => $router->password,
            ]);
            $query = new Query("/ppp/profile/print");

            // Send the query and fetch the results
            $profiles = $client->query($query)->read();

            // Initialize variables to store the final values
            $onUp = 'No script set';
            $onDown = 'No script set';

            // Now filter the profiles based on the $package->name
            foreach ($profiles as $profile) {
                $onUp = $profile['on-up'] ?? 'No script set';  // Check if 'on-up' is empty
                $onDown = $profile['on-down'] ?? 'No script set';  // Check if 'on-down' is empty
                
                // Print the values
                echo "On-Up: " . $onUp . "\n";
                echo "On-Down: " . $onDown . "\n";
            }

        } catch (\Exception $e) {
            return back()->with("error", __("Mikrotik connection fails"));
        }

        // Perform bulk update for all MikrotikParamter records associated with this user
        MikrotikParamter::where('user_id', $user->id)->update([
            'uptime' => $onUp,
            'down_time' => $onDown,
            'router_name' => $router->name,
            'router_ip' => $router->ip,
        ]);

        // Update user status to 'inactive'
        $user->detail->update(["status" => 'inactive']);

        return back()->with("success", __("Mikrotik updated successfully"));
    }
}