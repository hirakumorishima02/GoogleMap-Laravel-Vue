<?php

namespace App\Http\Controllers;

use App\Destination;
use Illuminate\Http\Request;
use App\Http\Resources\Destination AS DestinationResource;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DestinationResource::collection(Destination::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $destination = new Destination;
        $destination->name = $request->input('name','');
        $destination->lat = $request->input('lat','');
        $destination->lng = $request->input('lng','');
        $destination->photo = $request->input('photo','');
        $destination->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function show(Destination $destination)
    {
        return new DestinationResource($destination);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Destination $destination)
    {
        $destination->name = $request->input('name','');
        $destination->lat = $request->input('lat','');
        $destination->lng = $request->input('lng','');
        $destination->photo = $request->input('photo','');
        $destination->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destination $destination)
    {
        $destination->delete();
    }
}
