<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use DataTables;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Schema;

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
  
            $data = Laporan::join('peralatan', 'peralatan.id_alat', '=', 'laporan.id_peralatan')
            ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'laporan.id_status_pekerjaan')
            ->join('gardu_induk', 'gardu_induk.id', '=', 'laporan.id_gardu_induk')
            ->get([
                'laporan.*', 
                'peralatan.serial_number as serial_number', 
                'status_pekerjaan.nama as status_pekerjaan_name', 
                'gardu_induk.nama_gardu'
            ]);

            // dd($data);
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit">Edit</a>';

                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="Delete" class="btn btn-danger btn-sm delete">Delete</a>';

                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="preview" class="btn btn-warning btn-sm preview">Preview</a>';

                        return $btn;
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
        $param = $request->all();
        unset($param['id']);
        // dd($param);

        Laporan::updateOrCreate(
            [
                'id' => $request->id
            ], 
            $param
            // [
            //     'id_peralatan' => $request->id_peralatan,
            //     'nip' => $request->nip,
            //     'id_status_pekerjaan' => $request->id_status_pekerjaan,
            //     "tgl_pelaksanaan" => $request->tgl_pelaksanaan,
            //     "id_gardu_induk" => $request->id_gardu_induk,
            //     "busbar" => $request->busbar,
            //     "kapasitas" => $request->kapasitas,
            //     "hasil_pengujian_tahanan_kontak" => $request->hasil_pengujian_tahanan_kontak,
            //     "hasil_pengujian_tahanan_isolasi" => $request->hasil_pengujian_tahanan_isolasi,
            //     "arus_motor_open" => $request->arus_motor_open,
            //     "arus_motor_close" => $request->arus_motor_close,
            //     "waktu_open" => $request->waktu_open,
            //     "waktu_close" => $request->waktu_close,
            //     "kondisi_visual" => $request->kondisi_visual,
            //     "dokumentasi" => $request->dokumentasi,
            //     "pengawas_pekerjaan" => $request->pengawas_pekerjaan,
            //     "keterangan" => $request->keterangan
            // ]
        );
    
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
        // ->where('id_peralatan', $request->id_peralatan)
        // ->where('nip', $request->nip)
        // ->where('id_status_pekerjaan', $request->id_status_pekerjaan)
        ->first();

        return response()->json($data);
    }
    public function destroy(Request $request)
    {
        Laporan::where('id', $request->id)
        // ->where('id_peralatan', $request->id_peralatan)
        // ->where('nip', $request->nip)
        // ->where('id_status_pekerjaan', $request->id_status_pekerjaan)
        ->delete();
      
        return response()->json(['success'=>'deleted successfully.']);
    }

    function exportExcel($search){

        if($search == '0'){

            $data = Laporan::join('peralatan', 'peralatan.id_alat', '=', 'laporan.id_peralatan')
            ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'laporan.id_status_pekerjaan')
            ->join('gardu_induk', 'gardu_induk.id', '=', 'laporan.id_gardu_induk')
            ->get([
                'laporan.*', 
                'peralatan.serial_number as serial_number', 
                'status_pekerjaan.nama as status_pekerjaan_name', 
                'gardu_induk.nama_gardu'
            ]);

        }else{

            $data = Laporan::join('peralatan', 'peralatan.id_alat', '=', 'laporan.id_peralatan')
            ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'laporan.id_status_pekerjaan')
            ->join('gardu_induk', 'gardu_induk.id', '=', 'laporan.id_gardu_induk')
            ->get([
                'laporan.*', 
                'peralatan.serial_number as serial_number', 
                'status_pekerjaan.nama as status_pekerjaan_name', 
                'gardu_induk.nama_gardu'
            ]);

            foreach($this->column as $column){
                $data->where($column, 'LIKE', '%' . $search . '%' );
            }

        }

        $data_array[] = array(
            'peralatan',
            'nip',
            'status_pekerjaan',
            'alasan',
            'tanggal_pelaksanaan',
            'gardu_induk',
            'busbar',
            'kapasitas',
            'pengujian_kontak',
            'pengujian_isolasi',
            'arus_motor_open',
            'arus_motor_close',
            'waktu_open',
            'waktu_close',
            'kondisi_visual',
            'dokumentasi',
            'pengawas',
            'keterangan'
        );
        // echo '<pre>';
        foreach($data as $key => $row)
        {

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
            
            $data_array[] = array(
                'peralatan' => $row->id_peralatan,
                'nip' => $row->nip,
                'status_pekerjaan' => $status_laporan,
                'alasan' => $row->alasan_ditolak,
                'tanggal_pelaksanaan' => $row->tgl_pelaksanaan,
                'gardu_induk' => $row->id_gardu_induk,
                'busbar' => $row->busbar,
                'kapasitas' => $row->kapasitas,
                'pengujian_kontak' => $row->hasil_pengujian_tahanan_kontak,
                'pengujian_isolasi' => $row->hasil_pengujian_tahanan_isolasi,
                'arus_motor_open' => $row->arus_motor_open,
                'arus_motor_close' => $row->arus_motor_close,
                'waktu_open' => $row->waktu_open,
                'waktu_close' => $row->waktu_close,
                'kondisi_visual' => $row->kondisi_visual,
                'dokumentasi' => $row->dokumentasi,
                'pengawas' => $row->pengawas_pekerjaan,
                'keterangan' => $row->keterangan
            );
        }

        $this->cetak_excel($data_array);
        
    }

    public function cetak_pdf($search)
    {
        if($search == 0){

            $laporan = Laporan::join('peralatan', 'peralatan.id_alat', '=', 'laporan.id_peralatan')
            ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'laporan.id_status_pekerjaan')
            ->join('gardu_induk', 'gardu_induk.id', '=', 'laporan.id_gardu_induk')
            ->get([
                'laporan.*', 
                'peralatan.serial_number as serial_number', 
                'status_pekerjaan.nama as status_pekerjaan_name', 
                'gardu_induk.nama_gardu'
            ]);

        }else{

            $laporan = Laporan::join('peralatan', 'peralatan.id_alat', '=', 'laporan.id_peralatan')
            ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'laporan.id_status_pekerjaan')
            ->join('gardu_induk', 'gardu_induk.id', '=', 'laporan.id_gardu_induk')
            ->get([
                'laporan.*', 
                'peralatan.serial_number as serial_number', 
                'status_pekerjaan.nama as status_pekerjaan_name', 
                'gardu_induk.nama_gardu'
            ]);

            foreach($this->column as $column){
                $laporan->where($column, 'LIKE', '%' . $search . '%' );
            }

        }
    	

        $pdf = PDF::loadView('report.pdf', ['laporan' => $laporan])
        ->setOptions(['defaultFont' => 'sans-serif'])
        ->setPaper('a4', 'landscape');

        // return view('report.pdf')->with(['laporan' => $laporan]);
    	return $pdf->download('laporan.pdf');
    }

    public function cetak_excel($customer_data){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($customer_data);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Laporan.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    public function column(){

        return $columns = [
            'id_peralatan',
            'nip',
            'id_status_pekerjaan',
            'tgl_pelaksanaan',
            'id_gardu_induk',
            'busbar',
            'kapasitas',
            'hasil_pengujian_tahanan_kontak',
            'hasil_pengujian_tahanan_isolasi',
            'arus_motor_open',
            'arus_motor_close',
            'waktu_open',
            'waktu_close',
            'kondisi_visual',
            'dokumentasi',
            'pengawas_pekerjaan',
            'keterangan',
            'status',
            'alasan_ditolak'
        ];

    }
}
