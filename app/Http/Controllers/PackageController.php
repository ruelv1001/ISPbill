<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Router;
use Illuminate\Http\Request;
use RouterOS\Query;
use RouterOS\Client;
use phpseclib3\Net\SSH2;
class PackageController extends Controller
{
    public function index(Request $request)
    {
        $data = null; // Define $data to prevent "undefined variable" error
        $areaFilter = []; // Define $areaFilter to avoid undefined variable error

        if (auth()->user()->isUser()) {
            $user = auth()->user();
            // $router_name = $user->detail->router_name;
            // $router = Router::where("name", $router_name)->firstOrFail();
            // $packages = Package::where('router_id', $router->id)->orderBy('name')->get();

            $tabActive = $request->input('tab-active', 'port');
            $searchTerm = $request->input('search');
            $area = $request->input('port');
            $usersListQuery = Package::select('packages.*');

            if ($tabActive === 'package') {
                if ($request->filled('name')) {
                    $usersListQuery->where('packages.name', $request->input('name'));
                }
            }

            $areaFilter = [
                'name' => Package::distinct()->pluck('name', 'name')->toArray(),
            ];
            $data = $usersListQuery->paginate(10)->withQueryString();
        }

        if (auth()->user()->isAdmin()) {
            $data = Package::orderBy('name')->paginate(10)->withQueryString();
        }

        return view('packages.index', compact('data', 'areaFilter'));
    }
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $routers = Router::orderBy('name')->get();

        if (count($routers) == 0) {
            return redirect('packages')->with('error', __('Add a router first'));
        }



        return view('packages.create', compact('routers'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:packages',
            'router_id' => 'required',
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        $router = Router::where("id", $request->router_id)->firstOrFail();

        try {
            // Establish SSH connection using phpseclib
            $ssh = new SSH2($router->ip);

            if (!$ssh->login($router->username, $router->password)) {
                throw new \Exception("SSH login failed");
            }

            // Add PPP profile using Mikrotik CLI command
            $command = sprintf(
                "/ppp profile add name=\"%s\"",
                addslashes($request->name)
            );

            $ssh->exec($command);
        } catch (\Exception $e) {
            return back()->with("error", __("Mikrotik connection failed: " . $e->getMessage()));
        }

        $package = new Package();
        $package->fill($validated);
        $package->save();

        return redirect('packages')->with('success', __('Package successfully added'));
    }



    public function show(Package $package)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }
        return view('packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }
        return view('packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        $package->price = $validated['price'] ? $request->price : $package->price;
        $package->save();

        return redirect('packages')->with('success', __('Package successfullly updated'));
    }

    public function destroy(string $id)
    {

        $areaLocation = Package::find($id);


        if (!$areaLocation) {

            return response()->json(['message' => 'Package not found'], 404);
        }


        $areaLocation->delete();


        return response()->json(['message' => 'Package deleted successfully'], 200);
    }
}
