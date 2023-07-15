<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peralatan;
use DataTables;

class PeralatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
  
            $data = Peralatan::latest()->get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id_alat.'" data-idmerk="'.$row->id_merk_peralatan.'" data-idtipe="'.$row->id_type_peralatan.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id_alat.'" data-idmerk="'.$row->id_merk_peralatan.'" data-idtipe="'.$row->id_type_peralatan.'" data-original-title="Delete" class="btn btn-danger btn-sm delete">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('peralatan.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('merek.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Peralatan::updateOrCreate($request->all());
    
        return response()->json(['success'=>'Data Berhasil Disimpan.']);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('peralatan.show', compact('peralatan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // dd(json_decode($id));
        // dd($request->all());
        $data = Peralatan::where('id_alat', $request->id_alat)
        ->where('id_type_peralatan', $request->id_type_peralatan)
        ->where('id_merk_peralatan', $request->id_merk_peralatan)
        ->first();

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //    $request->validate([
    //         'nama' => 'required'
    //     ]);
    
    //     $status->update($request->all());
    
    //     return redirect()->route('peralatan.index')
    //                     ->with('success','Data Berhasil Diupdate');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Peralatan::where('id_alat', $request->id_alat)
        ->where('id_type_peralatan', $request->id_type_peralatan)
        ->where('id_merk_peralatan', $request->id_merk_peralatan)
        ->delete();
      
        return response()->json(['success'=>'deleted successfully.']);
    }
}
