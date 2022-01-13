<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeskListRequest;
use App\Http\Resources\DeskListReasource;
use App\Http\Resources\DeskResourse;
use App\Models\Desk;
use App\Models\DeskList;
use http\Env\Response;
use Illuminate\Http\Request;

class DeskListContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  DeskListReasource::collection(DeskList::all());
            }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeskListRequest $request)
    {
        $created_desklist = DeskList::create($request->validated());
        return new DeskListReasource($created_desklist);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new DeskListReasource(DeskList::with('Cards')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeskListRequest $request, DeskList $desklist)
    {
        $desklist->update($request->validated());

        return new DeskListReasource($desklist);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeskList $desklist)
    {
        return response(null, );
    }
}
