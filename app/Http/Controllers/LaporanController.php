<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use DataTables;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
  
            $data = Laporan::all();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="Delete" class="btn btn-danger btn-sm delete">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('laporan.index');
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

        // dd($request->all());
        Laporan::updateOrCreate([
            'id' => $request->id,
            'id_peralatan' => $request->id_peralatan,
            'nip' => $request->nip,
            'id_status_pekerjaan' => $request->id_status_pekerjaan
        ], 
        [
            "tgl_pelaksanaan" => $request->tgl_pelaksanaan,
            "id_gardu_induk" => $request->id_gardu_induk,
            "busbar" => $request->busbar,
            "kapasitas" => $request->kapasitas,
            "hasil_pengujian_tahanan_kontak" => $request->hasil_pengujian_tahanan_kontak,
            "hasil_pengujian_tahanan_isolasi" => $request->hasil_pengujian_tahanan_isolasi,
            "arus_motor_open" => $request->arus_motor_open,
            "arus_motor_close" => $request->arus_motor_close,
            "waktu_open" => $request->waktu_open,
            "waktu_close" => $request->waktu_close,
            "kondisi_visual" => $request->kondisi_visual,
            "dokumentasi" => $request->dokumentasi,
            "pengawas_pekerjaan" => $request->pengawas_pekerjaan,
            "keterangan" => $request->keterangan
        ]);
    
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
        $data = Laporan::where('id', $request->id)
        ->where('id_peralatan', $request->id_peralatan)
        ->where('nip', $request->nip)
        ->where('id_status_pekerjaan', $request->id_status_pekerjaan)
        ->first();

        return response()->json($data);
    }
    public function destroy(Request $request)
    {
        Laporan::where('id', $request->id)
        ->where('id_peralatan', $request->id_peralatan)
        ->where('nip', $request->nip)
        ->where('id_status_pekerjaan', $request->id_status_pekerjaan)
        ->delete();
      
        return response()->json(['success'=>'deleted successfully.']);
    }
}
