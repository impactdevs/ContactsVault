<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;


class ClientsController extends Controller
{
    
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Clients::all();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone_no' => 'required|string|max:15',
            'email' => 'required|email|unique:clients',
        ]);

        Clients::create($validatedData);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clients $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clients $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clients $client)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone_no' => 'required|string|max:15',
            'email' => 'required|email|unique:clients,email,' . $client->id,
        ]);

        $client->update($validatedData);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clients $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
