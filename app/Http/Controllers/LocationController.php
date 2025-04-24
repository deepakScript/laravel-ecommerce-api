<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'street' => 'required',
            'building' => 'required',
            'area' => 'required'
        ]);

        Location::create([
            'street' => $request->street,
            'building' => $request->building,
            'area' => $request->area,
            'user_id' => Auth::id(),
        ]);

        return response()->json('Location Added', 201);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'street' => 'required',
            'building' => 'required',
            'area' => 'required'
        ]);

        $location=Location::find($id);
        if($location){
        $location->street=$request->street;
        $location->building=$request->building;
        $location->area=$request->area;
        $location->save();

        return response()->json('Location Updated');
        }
        else return response()->json("Location isn't found");
    }


    public function destroy($id){
        $location = Location::find($id);
        if($location){
            $location->delete();
            return response()->json('Location Delted');
        }
        else return response()->json("Location does not found ");
    }
}
