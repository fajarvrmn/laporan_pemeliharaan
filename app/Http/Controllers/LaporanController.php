<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Peralatan;
use DataTables;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use App\Http\Controllers\Auth;

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

            $role = auth()->user()->role;

            // $whereByRole = ($role != '1') ? ['laporan.id_status_pekerjaan' => auth()->user()->role] : [] ;

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

            // $whereByRole = array_merge($whereByRole, $arrFilter);
  
            $laporan = Laporan::select('laporan.*', 
                'peralatan.serial_number as serial_number', 
                'peralatan.nama_bay as nama_bay', 
                'status_pekerjaan.nama as status_pekerjaan_name', 
                'gardu_induk.nama_gardu',
                'merek_peralatan.nama_merk as nama_merk',
                'type_peralatan.nama_type as nama_type',
                'users.name as user_name')
                    ->join('peralatan', 'peralatan.id_alat', '=', 'laporan.id_peralatan')
                    ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'laporan.id_status_pekerjaan')
                    ->join('gardu_induk', 'gardu_induk.id', '=', 'laporan.id_gardu_induk')
                    ->join('merek_peralatan', 'merek_peralatan.id', '=', 'laporan.merk')
                    ->join('type_peralatan', 'type_peralatan.id', '=', 'laporan.type')
                    ->join('users', 'users.nip', '=', 'laporan.pengawas_pekerjaan');

            if(isset($request->form_search)){
                $laporan->where($arrFilter);
            }

            if(!empty($rangeFilter['dari']) && !empty($rangeFilter['sampai'])) {
                $laporan->whereBetween('tgl_pelaksanaan', [$rangeFilter['dari'], $rangeFilter['sampai']]);
            }

            $laporan->get();
  
            return Datatables::of($laporan)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $role = auth()->user()->role;
                        
                        if($role == '1'){

                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"><i class="fa fa-edit"></i></a>';

                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></a>';

                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="preview" class="btn btn-warning btn-sm text-white preview"><i class="fa fa-eye"></i></a>';

                        }else{
                            $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-idperalatan="'.$row->id_peralatan.'" data-idnip="'.$row->nip.'" data-idstatus="'.$row->id_status_pekerjaan.'" data-original-title="preview" class="btn btn-warning btn-sm text-white preview"><i class="fa fa-eye"></i></a>';
                        }

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

        if(isset($request->dokumentasi)){

            $upload = uploadFile($request);
            $dokumentasi_image = $upload['file_name'];

            $param['dokumentasi'] = $dokumentasi_image;

        }

        if(isset($request->hasil_pengujian_tahanan_kontak) && isset($request->hasil_pengujian_tahanan_isolasi)){

            $kr = ($request->hasil_pengujian_tahanan_kontak[0] == "") ? "0" : $request->hasil_pengujian_tahanan_kontak[0];
            $ks = ($request->hasil_pengujian_tahanan_kontak[1] == "") ? "0" : $request->hasil_pengujian_tahanan_kontak[1];
            $kt = ($request->hasil_pengujian_tahanan_kontak[2] == "") ? "0" : $request->hasil_pengujian_tahanan_kontak[2];

            $ir = ($request->hasil_pengujian_tahanan_isolasi[0] == "") ? "0" : $request->hasil_pengujian_tahanan_isolasi[0];
            $is = ($request->hasil_pengujian_tahanan_isolasi[1] == "") ? "0" : $request->hasil_pengujian_tahanan_isolasi[1];
            $it = ($request->hasil_pengujian_tahanan_isolasi[2] == "") ? "0" : $request->hasil_pengujian_tahanan_isolasi[2];

            unset($param['hasil_pengujian_tahanan_kontak']);
            unset($param['hasil_pengujian_tahanan_isolasi']);

            $hu_kontak = $kr.','.$ks.','.$kt;
            $hu_isolasi = $ir.','.$is.','.$it;

            $param['hasil_pengujian_tahanan_kontak'] = $hu_kontak;
            $param['hasil_pengujian_tahanan_isolasi'] = $hu_isolasi;

        }

        Laporan::updateOrCreate(
            [
                'id' => $request->id
            ], 
            $param
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
        // $data = Laporan::where('id', $request->id)
        $data = Laporan::select('laporan.*', 
        'peralatan.serial_number as serial_number', 
        'peralatan.nama_bay as nama_bay', 
        'status_pekerjaan.nama as status_pekerjaan_name', 
        'gardu_induk.nama_gardu',
        'merek_peralatan.nama_merk as nama_merk',
        'type_peralatan.nama_type as nama_type',
        'users.name as user_name')
        ->join('peralatan', 'peralatan.id_alat', '=', 'laporan.id_peralatan')
        ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'laporan.id_status_pekerjaan')
        ->join('gardu_induk', 'gardu_induk.id', '=', 'laporan.id_gardu_induk')
        ->join('merek_peralatan', 'merek_peralatan.id', '=', 'laporan.merk')
        ->join('type_peralatan', 'type_peralatan.id', '=', 'laporan.type')
        ->join('users', 'users.nip', '=', 'laporan.pengawas_pekerjaan')
        ->where('laporan.id', $request->id)
        ->get();

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

    public function cetak_pdf(Request $request, $search)
    {
        $request = $request->toArray();
        $role = auth()->user()->role;

        // $whereByRole = ($role != '1') ? ['laporan.id_status_pekerjaan' => auth()->user()->role] : [] ;
        $whereByRole = [] ;

        $arrFilter = [];
        $rangeFilter = [];
        if(count($request) != 0){
            $i=0;
            foreach ($request as $key => $value) {
                if($value !== null){
                    if($key == 'tgl_pelaksanaan_dari'){
                        $rangeFilter['dari'] = $value;
                        unset($arrFilter[$key]);
                    }elseif($key == 'tgl_pelaksanaan_sampai'){
                        $rangeFilter['sampai'] = $value;
                        unset($arrFilter[$key]);
                    }
                    $arrFilter[$key] = $value;
                }

                $i++;
            }
        }

        unset($arrFilter['tgl_pelaksanaan_dari']);
        unset($arrFilter['tgl_pelaksanaan_sampai']);

        $whereByRole = array_merge($whereByRole, $arrFilter);

        $laporan = Laporan::select('laporan.*', 
        'peralatan.serial_number as serial_number', 
        'peralatan.nama_bay as nama_bay', 
        'status_pekerjaan.nama as status_pekerjaan_name', 
        'gardu_induk.nama_gardu')
        ->join('peralatan', 'peralatan.id_alat', '=', 'laporan.id_peralatan')
        ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'laporan.id_status_pekerjaan')
        ->join('gardu_induk', 'gardu_induk.id', '=', 'laporan.id_gardu_induk')
        ->where($whereByRole);

        if(!empty($rangeFilter['dari']) && !empty($rangeFilter['sampai'])) {
            $laporan->whereBetween('tgl_pelaksanaan', [$rangeFilter['dari'], $rangeFilter['sampai']]);
        }

        $laporan->get();

        $pdf = PDF::loadView('report.pdf', ['laporan' => $laporan->get()])
        ->setOptions(['defaultFont' => 'sans-serif'])
        ->setPaper('a4', 'landscape');

        return view('report.pdf')->with(['laporan' => $laporan->get()]);
    	// return $pdf->download('laporan.pdf');
    }

    function exportExcel(Request $request, $search){

        $request = $request->toArray();
        $role = auth()->user()->role;

        // $whereByRole = ($role != '1') ? ['laporan.id_status_pekerjaan' => auth()->user()->role] : [] ;
        $whereByRole = [] ;

        $arrFilter = [];
        $rangeFilter = [];
        if(count($request) != 0){
            $i=0;
            foreach ($request as $key => $value) {
                if($value !== null){
                    if($key == 'tgl_pelaksanaan_dari'){
                        $rangeFilter['dari'] = $value;
                        unset($arrFilter[$key]);
                    }elseif($key == 'tgl_pelaksanaan_sampai'){
                        $rangeFilter['sampai'] = $value;
                        unset($arrFilter[$key]);
                    }
                    $arrFilter[$key] = $value;
                }

                $i++;
            }
        }

        unset($arrFilter['tgl_pelaksanaan_dari']);
        unset($arrFilter['tgl_pelaksanaan_sampai']);

        $whereByRole = array_merge($whereByRole, $arrFilter);

        $laporan = Laporan::select('laporan.*', 
        'peralatan.serial_number as serial_number', 
        'peralatan.nama_bay as nama_bay', 
        'status_pekerjaan.nama as status_pekerjaan_name', 
        'gardu_induk.nama_gardu',
        'merek_peralatan.nama_merk as nama_merk',
        'type_peralatan.nama_type as nama_type',
        'users.name as user_name')
        ->join('peralatan', 'peralatan.id_alat', '=', 'laporan.id_peralatan')
        ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'laporan.id_status_pekerjaan')
        ->join('gardu_induk', 'gardu_induk.id', '=', 'laporan.id_gardu_induk')
        ->join('merek_peralatan', 'merek_peralatan.id', '=', 'laporan.merk')
        ->join('type_peralatan', 'type_peralatan.id', '=', 'laporan.type')
        ->join('users', 'users.nip', '=', 'laporan.pengawas_pekerjaan')
        ->where($whereByRole);

        if(!empty($rangeFilter['dari']) && !empty($rangeFilter['sampai'])) {
            $laporan->whereBetween('tgl_pelaksanaan', [$rangeFilter['dari'], $rangeFilter['sampai']]);
        }

        $laporan->get();

        //ini buat header title
        // $data_array[] = array(
        //     'Status Laporan',
        //     'Alasan',
        //     'Tanggal Pelaksanaan',
        //     'Gardu Induk',
        //     'Peralatan',
        //     'Rel',
        //     'Merek',
        //     'Tipe',
        //     'Kapasitas',
        //     'R '.html_entity_decode('&#181;',ENT_QUOTES,'UTF-8').'Ohm',
        //     'S '.html_entity_decode('&#181;',ENT_QUOTES,'UTF-8').'Ohm',
        //     'T '.html_entity_decode('&#181;',ENT_QUOTES,'UTF-8').'Ohm',
        //     'Tahanan Isolasi',
        //     'Arus Motor',
        //     'Waktu Open',
        //     'Waktu Close',
        //     'Kondisi Visual',
        //     'Dokumentasi',
        //     'Pengawas Pekerjaan',
        //     'Pelaksana Uji',
        //     'Status Pekerjaan',
        //     'Keterangan'
        // );

        // dd($laporan->get());

        foreach($laporan->get() as $key => $row)
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
            
            $exp_kontak = explode(",",$row->hasil_pengujian_tahanan_kontak);
            $r_kontak = $exp_kontak[0];
            $s_kontak = $exp_kontak[1];
            $t_kontak = $exp_kontak[2];

            $exp_isolasi = explode(",",$row->hasil_pengujian_tahanan_isolasi);
            $r_isolasi = $exp_isolasi[0];
            $s_isolasi = $exp_isolasi[1];
            $t_isolasi = $exp_isolasi[2];
            //ini value nya
            $data_array[] = array(
                'status_laporan' => $status_laporan,
                'alasan' => $row->alasan_ditolak,
                'tanggal_pelaksanaan' => $row->tgl_pelaksanaan,
                'gardu_induk' => $row->nama_gardu,
                'peralatan' => $row->nama_bay,
                'rel' => $row->rel,
                'merk' => $row->nama_merk,
                'type' => $row->nama_type,
                'kapasitas' => $row->kapasitas,
                // 'tahanan_kontak' => $row->hasil_pengujian_tahanan_kontak,
                'kontak_r' => $r_kontak,
                'kontak_s' => $s_kontak,
                'kontak_t' => $t_kontak,
                // 'tahanan_kontak' => $row->hasil_pengujian_tahanan_kontak,
                'isolasi_r' => $r_isolasi,
                'isolasi_s' => $s_isolasi,
                'isolasi_t' => $t_isolasi,
                // 'tahanan_isolasi' => $row->hasil_pengujian_tahanan_isolasi,
                'arus_motor' => $row->arus_motor,
                'waktu_open' => $row->waktu_open,
                'waktu_close' => $row->waktu_close,
                'kondisi_visual' => $row->kondisi_visual,
                'dokumentasi' => $row->dokumentasi,
                'pengawas' => $row->user_name,
                'pelaksana_uji' => $row->pelaksana_uji,
                'status_pekerjaan' => $row->status_laporan,
                'keterangan' => $row->keterangan
            );
        }

        // dd($data_array);

        $this->cetak_excel($data_array);
        
    }

    public function cetak_excel($data){

        // dd($data);

        try {

            $spreadsheet = new Spreadsheet();
            $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(30);

            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setPath(public_path('theme/dist/img/pln.png')); /* put your path and image here */
            $drawing->setCoordinates('B2');
            $drawing->setHeight(100);
            $drawing->setOffsetX(80); 
            $drawing->setOffsetY(3); 

            $drawing->setWorksheet($spreadsheet->getActiveSheet());
            
            $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(12);
            $spreadsheet->getActiveSheet()->mergeCells('B2:B5');

            // ----------------------- //

            $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing2->setPath(public_path('theme/dist/img/pdkb.png')); /* put your path and image here */
            $drawing2->setCoordinates('V2');
            $drawing2->setHeight(80);
            $drawing2->setOffsetX(5); 
            $drawing2->setOffsetY(10); 
            
            $drawing2->setWorksheet($spreadsheet->getActiveSheet());

            $spreadsheet->getActiveSheet()->mergeCells('V2:V5'); //rowsapan image pdkb
            $spreadsheet->getActiveSheet()->mergeCells('C2:X2');
            $spreadsheet->getActiveSheet()->mergeCells('C3:X3');
            $spreadsheet->getActiveSheet()->mergeCells('C4:X4');
            $spreadsheet->getActiveSheet()->mergeCells('C5:X5');
            $spreadsheet->getActiveSheet()->mergeCells('B6:X6');

            $spreadsheet->getActiveSheet()->setCellValue('C2','PT. PLN (PERSERO)'); 
            $spreadsheet->getActiveSheet()->setCellValue('C3','UNIT INDUK TRANSMISI JAWA BAGIAN TENGAH'); 
            $spreadsheet->getActiveSheet()->setCellValue('C4','UPT BANDUNG');
            $spreadsheet->getActiveSheet()->setCellValue('C5','PDKB TT/TET');
            $spreadsheet->getActiveSheet()->setCellValue('B6','LAPORAN PEMELIHARAAN');
            $spreadsheet->getActiveSheet()->getStyle('C2:C5')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('B6')->getFont()->setBold(true);

            $spreadsheet->getActiveSheet()->mergeCells('B7:B8');
            $spreadsheet->getActiveSheet()->mergeCells('C7:C8');
            $spreadsheet->getActiveSheet()->mergeCells('D7:D8');
            $spreadsheet->getActiveSheet()->mergeCells('E7:E8');
            $spreadsheet->getActiveSheet()->mergeCells('F7:F8');
            $spreadsheet->getActiveSheet()->mergeCells('G7:G8');
            $spreadsheet->getActiveSheet()->mergeCells('H7:H8');
            $spreadsheet->getActiveSheet()->mergeCells('O7:O8');
            $spreadsheet->getActiveSheet()->mergeCells('P7:P8');

            $spreadsheet->getActiveSheet()->mergeCells('I7:K7'); //tahanan kontak colspan
            $spreadsheet->getActiveSheet()->mergeCells('L7:N7'); //tahanan isolasi colspan

            $spreadsheet->getActiveSheet()->mergeCells('Q7:Q8');
            $spreadsheet->getActiveSheet()->mergeCells('R7:R8');
            $spreadsheet->getActiveSheet()->mergeCells('S7:S8');
            $spreadsheet->getActiveSheet()->mergeCells('T7:T8');
            $spreadsheet->getActiveSheet()->mergeCells('U7:U8');
            $spreadsheet->getActiveSheet()->mergeCells('V7:V8');
            $spreadsheet->getActiveSheet()->mergeCells('W7:W8');
            $spreadsheet->getActiveSheet()->mergeCells('X7:X8');
            $spreadsheet->getActiveSheet()->mergeCells('Y7:Y8');

            for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
                $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
            }

            $spreadsheet->getActiveSheet()->getRowDimension('9')->setRowHeight(25);

            // $spreadsheet->getActiveSheet()->setCellValue('B7', 'Status Laporan');
            // $spreadsheet->getActiveSheet()->setCellValue('C7', 'Alasan');
            $spreadsheet->getActiveSheet()->setCellValue('B7', 'Tanggal Pelaksanaan');
            $spreadsheet->getActiveSheet()->setCellValue('C7', 'Gardu Induk');
            $spreadsheet->getActiveSheet()->setCellValue('D7', 'Peralatan');
            $spreadsheet->getActiveSheet()->setCellValue('E7', 'Rel');
            $spreadsheet->getActiveSheet()->setCellValue('F7', 'Merek');
            $spreadsheet->getActiveSheet()->setCellValue('G7', 'Tipe');
            $spreadsheet->getActiveSheet()->setCellValue('H7', 'Kapasitas');
            $spreadsheet->getActiveSheet()->setCellValue('I7', 'Tahanan Kontak');
                $spreadsheet->getActiveSheet()->setCellValue('I8', 'R '.html_entity_decode('&#181;',ENT_QUOTES,'UTF-8').'Ohm');
                $spreadsheet->getActiveSheet()->setCellValue('J8', 'S '.html_entity_decode('&#181;',ENT_QUOTES,'UTF-8').'Ohm');
                $spreadsheet->getActiveSheet()->setCellValue('K8', 'T '.html_entity_decode('&#181;',ENT_QUOTES,'UTF-8').'Ohm');
            $spreadsheet->getActiveSheet()->setCellValue('L7', 'Tahanan Isolasi');
                $spreadsheet->getActiveSheet()->setCellValue('L8', 'R '.'Mohm');
                $spreadsheet->getActiveSheet()->setCellValue('M8', 'S '.'Mohm');
                $spreadsheet->getActiveSheet()->setCellValue('N8', 'T '.'Mohm');
            $spreadsheet->getActiveSheet()->setCellValue('O7', 'Arus Motor');
            $spreadsheet->getActiveSheet()->setCellValue('P7', 'Waktu Open');
            $spreadsheet->getActiveSheet()->setCellValue('Q7', 'Waktu Close');
            $spreadsheet->getActiveSheet()->setCellValue('R7', 'Kondisi Visual');
            // $spreadsheet->getActiveSheet()->setCellValue('U7', 'File Dokumentasi');
            $spreadsheet->getActiveSheet()->setCellValue('S7', 'Pengawas Pekerjaan');
            $spreadsheet->getActiveSheet()->setCellValue('T7', 'Pelaksana Uji');
            $spreadsheet->getActiveSheet()->setCellValue('U7', 'Status Pekerjaan');
            $spreadsheet->getActiveSheet()->setCellValue('V7', 'Keterangan');

            $char = range('A', 'Z'); //abjad array
            // $start_header_table = 1;
            // foreach ($data[0] as $key => $value) {

            //     $spreadsheet->getActiveSheet()->setCellValue($char[$start_header_table].'7', $value);

            //     $start_header_table ++;
            // }

            // dd($data);
            $spreadsheet->getActiveSheet()->getStyle('7')->getAlignment()->setVertical('center');
            $spreadsheet->getActiveSheet()->getStyle('7')->getAlignment()->setHorizontal('center');

            $start_col = 9;
            foreach ($data as $key => $value) {

                $spreadsheet->getActiveSheet()->getRowDimension($start_col)->setRowHeight(50);
                $spreadsheet->getActiveSheet()->getStyle($start_col)->getAlignment()->setVertical('center');
                $spreadsheet->getActiveSheet()->getStyle($start_col)->getAlignment()->setHorizontal('center');

                // $spreadsheet->getActiveSheet()->setCellValue($char[1].$start_col, $value['status_laporan']);
                // $spreadsheet->getActiveSheet()->setCellValue($char[2].$start_col, $value['alasan']);
                $spreadsheet->getActiveSheet()->setCellValue($char[1].$start_col, $value['tanggal_pelaksanaan']);
                $spreadsheet->getActiveSheet()->setCellValue($char[2].$start_col, $value['gardu_induk']);
                $spreadsheet->getActiveSheet()->setCellValue($char[3].$start_col, $value['peralatan']);
                $spreadsheet->getActiveSheet()->setCellValue($char[4].$start_col, $value['rel']);
                $spreadsheet->getActiveSheet()->setCellValue($char[5].$start_col, $value['merk']);
                $spreadsheet->getActiveSheet()->setCellValue($char[6].$start_col, $value['type']);
                $spreadsheet->getActiveSheet()->setCellValue($char[7].$start_col, $value['kapasitas']);
                $spreadsheet->getActiveSheet()->setCellValue($char[8].$start_col, $value['kontak_r']);
                $spreadsheet->getActiveSheet()->setCellValue($char[9].$start_col, $value['kontak_s']);
                $spreadsheet->getActiveSheet()->setCellValue($char[10].$start_col, $value['kontak_t']);
                $spreadsheet->getActiveSheet()->setCellValue($char[11].$start_col, $value['isolasi_r']);
                $spreadsheet->getActiveSheet()->setCellValue($char[12].$start_col, $value['isolasi_s']);
                $spreadsheet->getActiveSheet()->setCellValue($char[13].$start_col, $value['isolasi_t']);
                $spreadsheet->getActiveSheet()->setCellValue($char[14].$start_col, $value['arus_motor']);
                $spreadsheet->getActiveSheet()->setCellValue($char[15].$start_col, $value['waktu_open']);
                $spreadsheet->getActiveSheet()->setCellValue($char[16].$start_col, $value['waktu_close']);
                $spreadsheet->getActiveSheet()->setCellValue($char[17].$start_col, $value['kondisi_visual']);
                // $spreadsheet->getActiveSheet()->setCellValue($char[20].$start_col, $value['dokumentasi']);
                $spreadsheet->getActiveSheet()->setCellValue($char[18].$start_col, $value['pengawas']);
                $spreadsheet->getActiveSheet()->setCellValue($char[19].$start_col, $value['pelaksana_uji']);
                $spreadsheet->getActiveSheet()->setCellValue($char[20].$start_col, $value['status_pekerjaan']);
                $spreadsheet->getActiveSheet()->setCellValue($char[21].$start_col, $value['keterangan']);

                $start_col ++;
            }

            $filename = 'Laporan';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

            $writer->save('php://output');

        } catch (Exception $e) {
            return;
        }
        
    }

    // public function cetak_excel($data){

    //     // dd($data);
    //     ini_set('max_execution_time', 0);
    //     ini_set('memory_limit', '4000M');
    //     try {
    //         $spreadSheet = new Spreadsheet();
    //         $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
    //         $spreadSheet->getActiveSheet()->fromArray($data);
    //         $Excel_writer = new Xls($spreadSheet);
    //         header('Content-Type: application/vnd.ms-excel');
    //         header('Content-Disposition: attachment;filename="Laporan.xls"');
    //         header('Cache-Control: max-age=0');
    //         ob_end_clean();
    //         $Excel_writer->save('php://output');
    //         exit();
    //     } catch (Exception $e) {
    //         return;
    //     }
    // }

    public function column(){

        return $columns = [
            'id_peralatan',
            'nip',
            'id_status_pekerjaan',
            'alasan_ditolak',
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
            'status'
        ];

    }

    public function getPeralatan(Request $request, $id_alat){

        $data = Peralatan::select('peralatan.*', 
        'merek_peralatan.id as id_merk',
        'merek_peralatan.nama_merk as nama_merk',
        'type_peralatan.id as id_type',
        'type_peralatan.nama_type as nama_type')
        ->join('merek_peralatan', 'peralatan.id_merk_peralatan', '=', 'merek_peralatan.id')
        ->join('type_peralatan', 'peralatan.id_type_peralatan', '=', 'type_peralatan.id')
        ->where('peralatan.id_alat', $id_alat)
        ->get();

        return $data;

    }
}
