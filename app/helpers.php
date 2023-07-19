<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Tipe;
use App\Models\Merek;
use App\Models\Gardu;
use App\Models\Peralatan;
use App\Models\Status;



if(!function_exists('loggedin_user')){

    function loggedin_user(){

        $data = Role::all();

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

?>