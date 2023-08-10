<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personil;
use DataTables;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;

class PersonilController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
  
            // $data = Personil::latest()->get();

            $data = Personil::select('users.*','roles.name as role_name')
                    ->join('roles', 'roles.id', '=', 'users.role')->get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm edit"><i class="fa fa-edit"></i></a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('personil.index');
    }

    public function create(Request $request)
    {

        // dd($req);
        $param = $request->all();
        // $param['role'] = '1';
        $param['password'] = Hash::make($request->password);
        $create = Personil::create($param);
        return response()->json(['success'=>'Data Berhasil Disimpan.']);
    }

    // public function store(Request $request)
    // {
    //     // $id = $request->id;
    //     // dd($request->password);
    //     $param = $request->all();
    //     $param['password'] = Hash::make($request->password);
    //     $param['role'] = '1';

    //     // unset($param['id']);

    //     // dd($param);

    //     Personil::updateOrCreate($param);        
     
    //     return response()->json(['success'=>'Data Berhasil Disimpan.']);
    // }

    public function update(Request $request){
        // dd($request);
        $param = $request->all();
        // $param['role'] = '1';
        $param['password'] = Hash::make($request->password);
        // dd($param);
        $create = Personil::where('id', $request->id)
        ->update($param);
        
        return response()->json(['success'=>'Data Berhasil Diupdate.']);
    }
    
    public function show($id)
    {
        return view('personil.show', compact('personil'));
    }

    public function edit($id)
    {
        $data = Personil::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        Personil::find($id)->delete();
      
        return response()->json(['success'=>'Data Berhasil Dihapus']);
    }
}
