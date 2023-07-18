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
  
            $data = Peralatan::join('merek_peralatan', 'peralatan.id_merk_peralatan', '=', 'merek_peralatan.id')
            ->join('type_peralatan', 'peralatan.id_type_peralatan', '=', 'type_peralatan.id')
            ->get(['peralatan.*', 'merek_peralatan.nama_merk as nama_merk', 'type_peralatan.nama_type as nama_type']);
  
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
    
    public function create(Request $request)
    {
        Peralatan::create($request->all());
        return response()->json(['success'=>'Data Berhasil Disimpan.']);
    }

    public function update(Request $request){
        
        Peralatan::where('id_alat', $request->id_alat)
        ->where('id_merk_peralatan', $request->id_merk_peralatan)
        ->where('id_type_peralatan', $request->id_type_peralatan)
        ->update($request->all());

        return response()->json(['success'=>'Data Berhasil Disimpan.']);
    }

    // public function store(Request $request)
    // {
    //     Peralatan::updateOrCreate($request->all());
    
    //     return response()->json(['success'=>'Data Berhasil Disimpan.']);
    // }
    
    public function show($id)
    {
        return view('peralatan.show', compact('peralatan'));
    }

    public function edit(Request $request)
    {
        $data = Peralatan::where('id_alat', $request->id_alat)
        ->where('id_type_peralatan', $request->id_type_peralatan)
        ->where('id_merk_peralatan', $request->id_merk_peralatan)
        ->first();

        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        Peralatan::where('id_alat', $request->id_alat)
        ->where('id_type_peralatan', $request->id_type_peralatan)
        ->where('id_merk_peralatan', $request->id_merk_peralatan)
        ->delete();
      
        return response()->json(['success'=>'deleted successfully.']);
    }
}
