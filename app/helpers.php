<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Role;

if(!function_exists('loggedin_user')){

    function loggedin_user(){

        $list_role = Role::all();

        return $list_role;

    }

}

?>