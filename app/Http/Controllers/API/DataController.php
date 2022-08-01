<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Data;
use App\Http\Resources\DataResource;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Data::latest()->get();
        return response()->json([DataResource::collection($data), 'Data fetched.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'lokasi' => 'required',
            'foto_dokumentasi' => 'required',
            'foto_saksi' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $data = Data::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'lokasi' => $request->lokasi,
            'foto_dokumentasi' => $request->foto_dokumentasi,
            'foto_saksi' => $request->foto_saksi
         ]);
        
        return response()->json(['Data created successfully.', new DataResource($data)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Data::find($id);
        if (is_null($data)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new DataResource($data)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Data $data)
    {
        $validator = Validator::make($request->all(),[
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'lokasi' => 'required',
            'foto_dokumentasi' => 'required',
            'foto_saksi' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $data->judul = $request->judul;
        $data->isi = $request->isi;
        $data->lokasi = $request->lokasi;
        $data->foto_dokumentasi = $request->foto_dokumentasi;
        $data->foto_saksi = $request->foto_saksi;
        $data->save();
        
        return response()->json(['Data updated successfully.', new DataResource($data)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Data $data)
    {
        $data->delete();

        return response()->json('Data deleted successfully');
    }
}