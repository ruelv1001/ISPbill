<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRouterRequest;
use App\Http\Requests\UpdateRouterRequest;
use Illuminate\Http\Request;
use App\Models\Router;

class RouterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            redirect('/');
        }
        
        $routers = Router::orderBy("name","asc")->get();
        return view("router.index", compact("routers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        return view('router.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:routers',
            'location' => 'required',
            'ip'=> 'required|ip',
            'username'=> 'required',
            'password'=> 'required',
        ]);

        $router = new Router();
        $router->fill($validated);
        $router->save();

        return redirect('router')->with('success', __('Router successfully added'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Router $router)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Router $router)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }
        return view('router.edit', compact('router'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Router $router)
    {
        $validated = $request->validate([
            'location'=> 'nullable|string',
            'ip'=> 'required|ip',
            'username'=> 'required',
            'password'=> 'required',
        ]);

        $router->location = $validated['location'] ? $request->location : $router->location;
        $router->ip = $validated['ip'] ? $request->ip : $router->ip;
        $router->username = $validated['username'] ? $request->username : $router->username;
        $router->password = $validated['password'] ? $request->password : $router->password;
        $router->save();

        return redirect('router')->with('success', __('Router updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Router $router)
    {
        //
    }
}
