<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use DataTables;

class RoleController extends Controller
{
   public function index(Request $request)
    {
        if ($request->ajax()) {
  
            $get_role = Role::latest()->get();
  
            return Datatables::of($get_role)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editRole"><i class="fa fa-edit"></i></a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteRole"><i class="fa fa-trash"></i></a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('role.index');
    }

    public function store(Request $request)
    {
       Role::updateOrCreate([
                    'id' => $request->gardu_id
                ],
                [
                    'name' => $request->nama_role,
                    'description' => $request->deskripsi_role,
                                
        
                ]);        
     
        return response()->json(['success'=>'Role Berhasil Disimpan.']);
    }

    public function edit($id)
    {
        $get_role = Role::find($id);
        return response()->json($get_role);
    }

     public function show($id)
    {
        return view('role.show',compact('role'));
    }

     public function update(Request $request, $id)
    {
       $request->validate([
            'name' => 'required',
            'description' => 'required',
        
        ]);
    
        $role->update($request->all());
    
        return redirect()->route('role.index')
                        ->with('success','Role Berhasil Ditambahkan');
    }

      public function destroy($id)
    {
        Role::find($id)->delete();
      
        return response()->json(['success'=>'Role deleted successfully.']);
    }
}
