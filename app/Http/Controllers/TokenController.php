<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = DB::table('token_notification')->get();
        return $token;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = DB::table('token_notification')->insertGetId([
            'token' => $request->token
        ]);

        $carnet = DB::table('alumno')->select('carnet')->where('gsuite', $request->correo)->first();

        DB::table('detalle_token_notification')->insert([
            'id_alumno' => $carnet->carnet,
            'id_token' => $token,
        ]);

        return "datos insertados";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }

    public function getTokenAlumno(Request $request){
        $carnet = DB::table('alumno')->select('carnet')->where('gsuite', $request->correo)->first();

        $tokens = DB::table('detalle_token_notification')->join('token_notification', 'detalle_token_notification.id_token', '=', 'token_notification.id')->where('id_alumno', $carnet->carnet)->get();

        return $tokens;
    }
}
