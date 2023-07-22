<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;
use App\Models\Peralatan;
use App\Models\Laporan;
use App\Models\Berkas;
use DataTables;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            // dd($request->form_search);

            $role = auth()->user()->role;

            // $column = ($role != '1') ? 'laporan.id_status_pekerjaan' : null;
            // $useRole = ($role != '1') ? auth()->user()->role : null;

            $whereByRole = ($role != '1') ? ['laporan.id_status_pekerjaan' => auth()->user()->role] : [] ;

            $arrFilter = [];
            $rangeFilter = [];
            if(isset($request->form_search)){
                $i=0;
                foreach ($request->form_search as $key => $value) {
                    if($value['value'] !== null){
                        if($value['name'] == 'tgl_pelaksanaan_dari'){
                            $rangeFilter['dari'] = $value['value'];
                            unset($arrFilter[$key]);
                        }elseif($value['name'] == 'tgl_pelaksanaan_sampai'){
                            $rangeFilter['sampai'] = $value['value'];
                            unset($arrFilter[$key]);
                        }
                        $arrFilter[$value['name']] = $value['value'];
                    }

                    $i++;
                }
            }

            unset($arrFilter['tgl_pelaksanaan_dari']);
            unset($arrFilter['tgl_pelaksanaan_sampai']);

            $whereByRole = array_merge($whereByRole, $arrFilter);
  
            $laporan = Laporan::join('peralatan', 'peralatan.id_alat', '=', 'laporan.id_peralatan')
            ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'laporan.id_status_pekerjaan')
            ->join('gardu_induk', 'gardu_induk.id', '=', 'laporan.id_gardu_induk')
            ->where($whereByRole);

            if(!empty($rangeFilter['dari']) && !empty($rangeFilter['sampai'])) {
                $laporan->whereBetween('tgl_pelaksanaan', [$rangeFilter['dari'], $rangeFilter['sampai']]);
            }

            $laporan->get([
                'laporan.*', 
                'peralatan.serial_number as serial_number', 
                'status_pekerjaan.nama as status_pekerjaan_name', 
                'gardu_induk.nama_gardu'
            ]);
  
            return Datatables::of($laporan)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    // $role = auth()->user()->role;
                    
                    // if($role == '1'){

                    //     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Ubah</a>';

                    //     $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="Delete" class="btn btn-danger btn-sm delete">Hapus</a>';

                    //     $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="preview" class="btn btn-warning btn-sm text-white preview">Detail</a>';

                    // }else{
                    //     $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="preview" class="btn btn-warning btn-sm text-white preview">Preview</a>';
                    // }

                    // return $btn;
                })
                ->addColumn('status_text', function($row){
                    $status_laporan = "Unknown";
                    if($row->id_status_pekerjaan == '1' && $row->status == '0'){ //belum dikirim admin
                        $status_laporan = 'Belum Dikirim Oleh Admin';   
                    }elseif($row->id_status_pekerjaan == '2' && $row->status == '0'){
                        $status_laporan = 'Sudah Dikirim Oleh Admin';
                    }elseif($row->id_status_pekerjaan == '2' && $row->status == '1'){
                        $status_laporan = 'Ditolak Oleh Supervisor';
                    }elseif($row->id_status_pekerjaan == '3' && $row->status == '0'){
                        $status_laporan = 'Sudah Disetujui Oleh Supervisor';
                    }elseif($row->id_status_pekerjaan == '3' && $row->status == '1'){
                        $status_laporan = 'Ditolak Oleh Manager';
                    }elseif($row->id_status_pekerjaan == '4' && $row->status == '0'){
                        $status_laporan = 'Sudah Disetujui Oleh Manager';
                    }
                    return $status_laporan;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $dataCount = [
            'total_peralatan' => Peralatan::count(),
            'total_laporan' => Laporan::count(),
            'total_berkas' => Berkas::count()
        ];
        
        return view('dashboard.index')->with(['total_data' => $dataCount]);
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
       Gardu::updateOrCreate([
                    'id' => $request->gardu_id
                ],
                [
                    'nama_gardu' => $request->nama_gardu
        
                ]);        
     
        return response()->json(['success'=>'Gardu Berhasil Disimpan.']);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('gardu.show',compact('gardu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $get_gardu = Gardu::find($id);
        return response()->json($get_gardu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $request->validate([
            'nama_gardu' => 'required',
        
        ]);
    
        $gardu->update($request->all());
    
        return redirect()->route('garduinduk.index')
                        ->with('success','Gardu Berhasil Ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gardu::find($id)->delete();
      
        return response()->json(['success'=>'Gardu deleted successfully.']);
    }
}
