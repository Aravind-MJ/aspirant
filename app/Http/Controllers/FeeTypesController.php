<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Feetypes;
use App\Batch;
use App\Encrypt;

class FeeTypesController extends Controller
{
    protected $feetypes, $batch;

    public function __construct(Feetypes $feetypes, Batch $batch) {
        $this->feetypes = $feetypes;
        $this->batch = $batch;
    }
    public function index()
    {
        
         $allFeetypes = $this->feetypes
                ->join('batch_details', 'batch_details.id', '=', 'fee_types.batch_id')
                ->select('fee_types.*', 'batch_details.batch')
                ->orderBy('fee_types.created_at', 'DESC')
                ->get();
     foreach($allFeetypes as $feetypes){
             $feetypes->enc_id = Encrypt::encrypt($feetypes->id);
     }
        return View('Feetypes.list_Feetypes', compact('allFeetypes'));
    }

   
//        
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
       $batch =$this->batch
                ->select('id', 'batch')
                ->get();
        $data = array();
        foreach ($batch as $batch) {
            $data[$batch->id] = $batch->batch;
        }
        $batch = $data;
        //Redirecting to add_notice.blade.php 

        return view('Feetypes.add_Feetypes', compact('Feetypes','id', 'batch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\PublishFeetypesRequest $requestData)
    {
          $feetypes = new \App\Feetypes;
             $feetypes->batch_id= $requestData['batch_id'];
             $feetypes->total_fee = $requestData['total_fee'];
         
          $feetypes->save();
           return redirect()->route('FeeTypes.create')
                            ->withFlashMessage('Feetype Added successfully!')
                            ->withType('success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id){
//           $allFeetypes = $this->feetypes
//                ->join('batch_details', 'batch_details.id', '=', 'fee_types.batch_id')
//                ->select('fee_types.*', 'batch_details.batch')
//                ->orderBy('fee_types.created_at', 'DESC')
//                ->get();
//
//       return View('Feetypes.list_Feetypes', compact('Feetypes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
         $enc_id=$id;
         $id = Encrypt::decrypt($id);
        
        $Feetypes = $this->feetypes
                ->join('batch_details', 'batch_details.id', '=', 'fee_types.batch_id')
                 ->select('fee_types.*', 'batch_details.batch')
                ->where('fee_types.id', $id)
                ->first();

        //Fetch Batch Details
        $batch = $this->batch
                ->select('id', 'batch')
                ->get();
        $data = array();
        foreach ($batch as $batch) {
            $data[$batch->id] = $batch->batch;
        }
        $batch = $data;

        return View('Feetypes.edit_Feetypes', compact('Feetypes', 'batch', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, Requests\PublishFeetypesRequest $requestData)
    {
        
        $feetypes = \App\Feetypes::find($id);
         $feetypes ->batch_id= $requestData['batch_id'];
          
             $feetypes->total_fee = $requestData['total_fee'];
          $feetypes ->save();
        return redirect()->route('FeeTypes.index')
                        ->withFlashMessage('fee Updated successfully!')
                        ->withType('success');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
         $enc_id=$id;
        $id = Encrypt::decrypt($id);
        \App\Feetypes::find($id)->delete();

        //Redirecting to index() method
        return redirect()->route('FeeTypes.index');
    }
}
