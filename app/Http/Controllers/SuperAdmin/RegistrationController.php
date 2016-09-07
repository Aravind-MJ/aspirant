<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Encrypt;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\RegistrationFormRequest;
use App\Http\Requests\AdminEditFormRequest;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Sentinel;
use Illuminate\Support\Facades\Redirect;

class RegistrationController extends Controller
{

    /**
     * @var $user
     */
    protected $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of all admins.
     *
     * @return Response
     */
    public function index()
    {
        $admin = Sentinel::findRoleByName('Admins');
        $users = $admin->users()->with('roles')->get();
        foreach ($users as $user) {
            $user->enc_id = Encrypt::encrypt($user->id);
        }
        return view('protected.Superadmin.list_admins')->withUsers($users);
    }

    /**
     * Show the form for creating a new Admin.
     *
     * @return Response
     */
    public function create()
    {
        return view('registration.create');
    }

    /**
     * Store the newly created Admin to database.
     *
     * @return Response
     */
    public function store(RegistrationFormRequest $request)
    {
        $input = $request->only('email', 'password', 'first_name', 'last_name');

        $user = Sentinel::registerAndActivate($input);

        // Find the role using the role name
        $usersRole = Sentinel::findRoleByName('Admins');

        // Assign the role to the users
        $usersRole->users()->attach($user);

        return redirect('create/admin')->withFlashMessage('Admin created Successfully')->withType('success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $enc_id = $id;
        $id = Encrypt::decrypt($id);
        try {
            $user = $this->user->find($id);
            $user->enc_id = $enc_id;

        } catch (Exception $e) {
            return redirect('list/admin')->withFlashMessage('Invalid Request!')->withType('danger');
        }

        return view('registration.edit')->withUser($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, AdminEditFormRequest $request)
    {   
        $enc_id = $id;
        $id = Encrypt::decrypt($id);
        try {
            $user = $this->user->find($id);
        } catch(Exception $e){
            return redirect('list/admin')->withFlashMessage('Profile Edit Failed!')->withType('danger');
        }

        $input = $request->only('first_name', 'last_name');

        $user->where('id',$id);
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->save();

        return redirect::back()
            ->withFlashMessage('Profile has been Edited successfully!')
            ->withType('success');
    }

    /**
     * Show the form for creating a new Admin.
     *
     * @return Response
     */
    public function destroy($id)
    {
        $id = Encrypt::decrypt($id);
        try {
            $this->user->find($id)->delete();
        } catch (Exception $e) {
            return redirect('list/admins')->withFlashMessage('Admin deletion Failed')->withType('danger');
        }

        return redirect('list/admins')->withFlashMessage('Admin deleted Successfully')->withType('success');
    }
}
