<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {                              
        //return $startDate;          
        return Asistencia::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Hora = date("H");                
        if(($Hora>=6 && $Hora<=10)){            
            $i = date("y-m-d")." 06:00";
            $f = date("y-m-d")." 10:59";
            $dato = Asistencia::where('id_alumno',$request->id_alumno)->whereBetween('created_at', [$i, $f])->get();                    
            if(count($dato)==0){                
                $asistencia = new Asistencia();
                $asistencia->id_alumno = $request->id_alumno;        
                $asistencia->tipo = "entrada";        
                $asistencia->save();
                return $asistencia;
            }else{
                return response()->json("dato ya registrado",201);
            }
        }else if(($Hora>=11 && $Hora<=17)){
            $i = date("y-m-d")." 11:00";
            $f = date("y-m-d")." 17:30";
            $dato = Asistencia::where('id_alumno',$request->id_alumno)->whereBetween('created_at', [$i, $f])->get();              
            if(count($dato)==0){
                $asistencia = new Asistencia();
                $asistencia->id_alumno = $request->id_alumno;   
                $asistencia->tipo = "salida";     
                $asistencia->save();
                return $asistencia;
            }else{
                return response()->json("dato ya registrado",201);
            }
        }  
                
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function show(Asistencia $asistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asistencia $asistencia)
    {
        //
    }
}
