<?php

namespace App\Http\Controllers;

use App\Models\BasesCrud;
use Illuminate\Http\Request;
use App\Repositories\BaseCrud\BaseCrudRepository;

class BaseCrudController extends Controller
{

    protected $baseCrudRepository;

    public function __construct(BaseCrudRepository $baseCrudRepository)
    {
        $this->baseCrud = $baseCrudRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return response()->json(Base::all());
        return response()->json($this->baseCrud->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json($this->baseCrud->create($request->all()));
    }

    /**
     * Show the form for show the specified resource.
     *
     * @param  \App\Models\BasesCrud  $base
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->baseCrud->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BasesCrud  $base
     * @return \Illuminate\Http\Response
     */
    public function edit(BasesCrud $base,$id)
    {
        return response()->json(BasesCrud::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Base  $base
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $crud = $this->baseCrud->find($id);
        return response()->json($this->baseCrud->update($crud, $request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BaseCrud  $base
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $crud = $this->baseCrud->find($id);
        return response()->json($this->baseCrud->delete($crud));
    }
}
