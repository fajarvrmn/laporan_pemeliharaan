<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;
use App\Models\Peralatan;
use App\Models\Laporan;
use App\Models\Berkas;
use DataTables;
use DB;

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

            $search = "";
            if(isset($request->search)){
                $search = $request->search;
            }
            
            $laporan = Laporan::select('laporan.*', 
            'peralatan.serial_number as serial_number',
            'peralatan.nama_bay as nama_bay', 
            'status_pekerjaan.nama as status_pekerjaan_name', 
            'gardu_induk.nama_gardu',
            DB::raw('(CASE WHEN laporan.id_status_pekerjaan = 1 AND laporan.status = 0 THEN "Belum Dikirim Oleh Admin"
            WHEN laporan.id_status_pekerjaan = 2 AND laporan.status = 0 THEN "Sudah Dikirim Oleh Admin"
            WHEN laporan.id_status_pekerjaan = 2 AND laporan.status = 1 THEN "Ditolak Oleh Supervisor"
            WHEN laporan.id_status_pekerjaan = 3 AND laporan.status = 0 THEN "Sudah Disetujui Oleh Supervisor"
            WHEN laporan.id_status_pekerjaan = 3 AND laporan.status = 1 THEN "Ditolak Oleh Manager"
            WHEN laporan.id_status_pekerjaan = 4 AND laporan.status = 0 THEN "Sudah Disetujui Oleh Manager"
            ELSE "Unknown" END) AS status_pekerjaan_text')
            )
            ->join('peralatan', 'peralatan.id_alat', '=', 'laporan.id_peralatan')
            ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'laporan.id_status_pekerjaan')
            ->join('gardu_induk', 'gardu_induk.id', '=', 'laporan.id_gardu_induk');

            $data = $laporan;

            return response()->json(
                [
                    'success' => true, 
                    'data' => $this->linear_search($data->get()->toArray(), $search)
                ]
            );

        }

        $dataCount = [
            'total_peralatan' => Peralatan::count(),
            'total_laporan' => Laporan::count(),
            'total_berkas' => Berkas::count()
        ];
        
        return view('dashboard.index')->with(['total_data' => $dataCount]);
    }

    private function linear_search($data, $search="")
    {
        // dd($data);
        // exit;
        $i = 0;
        $message = '';
        $total = 0;
        $result = false;
        $response = [];

        if(count($data) != 0){
            
            $start = microtime(true);

            foreach ($data as $key1 => $value1) {

                if($search == ""){

                    $result = true;
                    $response[$i] = $value1;

                }else{
                    
                    foreach ($data[$i] as $key => $value) {

                        $responseData = $data[$i];

                        // $responseData[$key] = $value;

                        if(strtolower($key) == 'nama_bay'){
                            if($value == $search){
                                $message = "Laporan dengan nama bay ".$search." ditemukan !";
                                $result = true;
                                // $response[$i] = $data[$i];
                                break;
                            }
                        }elseif(strtolower($key) == 'serial_number'){
                            if($value == $search){
                                $message = "Laporan dengan serial number ".$search." ditemukan !";
                                $result = true;
                                // $response[$i] = $data[$i];
                                break;
                            }
                        }elseif(strtolower($key) == 'nama_gardu'){
                            if($value == $search){
                                $message = "Laporan dengan nama gardu ".$search." ditemukan !";
                                $result = true;
                                // $response[$i] = $data[$i];
                                break;
                            }
                        }
                    }

                    // dd($responseData);
                    $response[$i] = ($result) ? $responseData : [];
                }

                $i++;
            }

            $end = microtime(true);

            $estTime = substr(($end - $start), 0,5);

        }

        return [
            'result' => $result,
            'msg' => $message,
            'time' => "Waktu yang dibutuhkan: " . ($estTime)  . " detik",
            'data' => $response
        ];
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
