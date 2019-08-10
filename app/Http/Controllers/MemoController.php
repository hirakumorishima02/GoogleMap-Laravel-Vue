<?php

namespace App\Http\Controllers;

use App\Memo;
use Illuminate\Http\Request;
use App\Http\Resources\Memo AS MemoResource;

class MemoController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $memo = new Memo;
        $memo->destination_id = $request->input('id',''); // destination_idをどのように呼び出すか
        $memo->content = $request->input('content','');
        $memo->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Memo  $memo
     * @return \Illuminate\Http\Response
     */
    public function show(Memo $memo)
    {
        return new MemoResource($memo);// destination_idをどのように呼び出すか
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Memo  $memo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Memo $memo)
    {
        $memo->content = $request->input('content','');
        $memo->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Memo  $memo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Memo $memo)
    {
        $memo->delete();
    }
}
