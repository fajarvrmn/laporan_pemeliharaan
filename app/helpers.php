<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

use App\Models\Role;
use App\Models\Tipe;
use App\Models\Merek;
use App\Models\Gardu;
use App\Models\Peralatan;
use App\Models\Status;
use App\Models\User;




if(!function_exists('loggedin_user')){

    function loggedin_user(){

        $data = Role::all();

        return $data;

    }

}

if(!function_exists('getAllUsers')){

    function getAllUsers(){

        $data = User::all();

        return $data;

    }

}

if(!function_exists('getRole')){

    function getRole(){

        $data = Role::all();

        return $data;

    }

}

if(!function_exists('getTypePeralatan')){

    function getTypePeralatan(){

        $data = Tipe::all();

        return $data;

    }

}

if(!function_exists('getMerkPeralatan')){

    function getMerkPeralatan(){

        $data = Merek::all();

        return $data;

    }

}

if(!function_exists('getGarduInduk')){

    function getGarduInduk(){

        $data = Gardu::all();

        return $data;

    }

}

if(!function_exists('getPeralatan')){

    function getPeralatan(){

        $data = Peralatan::all();

        return $data;

    }

}

if(!function_exists('getStatusPekerjaan')){

    function getStatusPekerjaan(){

        $data = Status::all();

        return $data;

    }

}

if(!function_exists('uploadFile')){

    function uploadFile(Request $request){

        // $fileName = time().'.'.$request->dokumentasi->getClientOriginalExtension();
        $fileName = 'doc-' . time() . '.' . $request->dokumentasi->getClientOriginalExtension();
        $request->dokumentasi->move(public_path('/uploads/images/'), $fileName);

        return ['file_name' => $fileName];

    }

}

?>