<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Tipe;
use App\Models\Merek;

if(!function_exists('loggedin_user')){

    function loggedin_user(){

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

?>