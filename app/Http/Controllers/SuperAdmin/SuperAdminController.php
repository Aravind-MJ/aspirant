<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RoleUsers;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    protected $faculty, $students, $admins, $users;

    public function __construct(RoleUsers $user)
    {
        $this->users = $user;
    }

    public function getHome()
    {
        $count = array();
        $title = 'Super Admin | Home';
        $roles = [1=>'users', 2=>'admins', 3=>'superadmin', 4=>'faculty'];
        foreach($roles as $id =>$role){
            $data = $this->users
                ->join('users','role_users.user_id','=','users.id')
                ->where(array(
                    'users.deleted_at'=>null,
                    'role_users.role_id'=>$id
                ))
                ->get();
            $count[$role] = count($data);
        }

        return view('protected.dashboard', [
            'title' => $title,
            'count' => $count
        ]);
    }

}
