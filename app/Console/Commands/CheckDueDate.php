<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Router;
use App\Models\User;
use RouterOS\Client;
use RouterOS\Query;
class CheckDueDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:check-due-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if billing_date is past and update status to Inactive';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = Carbon::now();

        // Get all users whose service details need to be updated
        $users = DB::table('service_details')
            ->where('billing_date', '<', $currentDate)
            ->where('status', '!=', 'Inactive')
            ->get();

        foreach ($users as $serviceDetail) {
      
            DB::table('service_details')
                ->where('id', $serviceDetail->id)
                ->update(['status' => 'Inactive']);


            $user = User::find($serviceDetail->user_id);

            if ($user && $user->detail) {

                $router_name = $user->detail->router_name;
                $router = Router::where("name", $router_name)->first();

                if ($router) {
                    try {

                        $client = new Client([
                            "host" => $router->ip,
                            "user" => $router->username,
                            "pass" => $router->password,
                        ]);


                        $query = new Query("/ppp/secret/disable");
                        $query->equal("numbers", $user->id);
                        $client->query($query)->read();

                    } catch (\Exception $e) {

                    }
                }
            }
        }

        $this->info('Service statuses updated and users disabled successfully.');

        return 0;
    }
}
