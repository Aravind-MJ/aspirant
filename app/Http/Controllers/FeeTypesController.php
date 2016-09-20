<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Feetypes;

class FeeTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $allFeetypes = \App\Feetypes::all();    //Eloquent ORM method to return all matching results
        //Redirecting to list_faculty.blade.php with $allFaculties       
        return View('Feetypes.list_Feetypes', compact('allFeetypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Feetypes.add_Feetypes')->with('message', 'Message sent!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PublishFeetypesRequest$requestData)
    {
          $Feetypes = new \App\Feetypes;
          $Feetypes->name= $requestData['name'];//
          $Feetypes->save();
           return redirect()->route('FeeTypes.create')
                            ->withFlashMessage('Feetype Added successfully!')
                            ->withType('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
       $Feetypes = Feetypes::find($id);

        return view('Feetypes.list_Feetypes')->with('Feetypes', $Feetypes);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
       $Feetypes = \App\Feetypes::find($id);

  
        return view('Feetypes.edit_Feetypes')->with('Feetypes', $Feetypes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Requests\PublishFeetypesRequest $requestData)
    {
        $Feetypes = \App\Feetypes::find($id);
        $Feetypes->name = $requestData['name']; 
        $Feetypes->save();

        //Send control to index() method
        return redirect()->route('FeeTypes.index')
                         ->withFlashMessage('Feetype Updated successfully!')
                         ->withType('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
       \App\Feetypes::find($id)->delete();

        //Redirecting to index() method
        return redirect()->route('FeeTypes.index');
    }
}
