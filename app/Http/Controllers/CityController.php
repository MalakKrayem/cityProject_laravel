<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        return response()->view("cms.cities.index", compact("cities"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view("cms.cities.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name_en" => "unique:cities|min:3|max:20|required|string",
            "name_ar" => "unique:cities|min:3|max:20|required|string",
            "active" => "nullable|string|in:on"

        ]);
        $city = new City();
        $city->name_en = $request->input('name_en');
        $city->name_ar = $request->input('name_ar');
        $city->active = $request->has("active");
        $isSaved = $city->save();
        if ($isSaved) {
            return redirect()->route("cities.index")->with("success", "The city Saved Successfuly!");
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return response()->view("cms.cities.update", compact("city"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $request->validate([
            "name_en" => "min:3|max:20|required|string",
            "name_ar" => "min:3|max:20|required|string",
            "active" => "nullable|string|in:on"

        ]);
        $city->name_en = $request->input('name_en');
        $city->name_ar = $request->input('name_ar');
        $city->active = $request->has("active");
        $isUpdated = $city->save();
        if ($isUpdated) {
            return redirect()->route("cities.index")->with("success", "The city Updated Successfuly!");
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $isDelete = $city->delete();
        if ($isDelete) {
            return redirect()->back()->with("success", "The city deleted successfuly!");
        }
    }
}
