<?php

namespace App\Http\Controllers;

use App\Encrypt;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Repositories\UserRepositoryInterface;

class ChangePasswordController extends Controller
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        return view('changePassword',['enc_id'=>$id]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, ChangePasswordRequest $request)
    {
        $id = Encrypt::decrypt($id);
        try {
            $user = $this->user->find($id);
            $user->password = \Hash::make($request->input('password'));
            $user->save();
        } catch(Exception $e){
            return redirect()->back()->withFlashMessage('Password Change Failed!!')->withType('danger');
        }

        return redirect()->back()->withFlashMessage('Password Changed Successfully!')->withType('success');


    }
}
