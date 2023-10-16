<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function listarAsistenciaAlumno(Request $request){
        $alumno = DB::table('alumno')->where('gsuite', $request->correo)->first();
        $asistencia = Asistencia::
        selectRaw('alumno.nombres, alumno.apellidos, asistencias.tipo, CONCAT(UPPER(SUBSTRING(DATE_FORMAT(asistencias.created_at, "%W %d %M %Y"),1,1)),LOWER(SUBSTRING(DATE_FORMAT(asistencias.created_at, "%W %d %M %Y"),2))) as fecha , DATE_FORMAT(asistencias.created_at, "%H:%i:%s") as hora')
        ->where('id_alumno', $alumno->carnet)
        ->join('alumno', 'alumno.carnet', '=', 'asistencias.id_alumno')
        ->orderBy('created_at')->get();
        return $asistencia;
    }

    public function estadisticaAsistencia(Request $request){
        $alumno = DB::table('alumno')->where('gsuite', $request->correo)->first();
        $asistencias = Asistencia::
        selectRaw('COUNT(id) AS asistencias')
        ->where('tipo', 'entrada')
        ->whereBetween('created_at', ['2023-07-31', '2023-10-13'])
        ->where('id_alumno', $alumno->carnet)->first();

        $justificaciones = Asistencia::
        selectRaw('COUNT(id) AS justificaciones')
        ->whereRaw('excusa IS NOT NULL')
        ->whereBetween('created_at', ['2023-07-31', '2023-10-13'])
        ->where('id_alumno', $alumno->carnet)->first();

        $asistenciasT = round(($asistencias->asistencias/55)*100,0);
        $justificacionesT = round(($justificaciones->justificaciones/55)*100,0);
        $inasistenciasT = round(((55-$asistencias->asistencias-$justificaciones->justificaciones)/55)*100,0);

        return compact('asistenciasT', 'justificacionesT', 'inasistenciasT');
    }

    public function estadisticaHoraEntrada(Request $request){
        $alumno = DB::table('alumno')->where('gsuite', $request->correo)->first();

        $asistencia = DB::table('asistencias')
        ->selectRaw('DATE_FORMAT(created_at, "%W") as dia, DATE_FORMAT(created_at, "%H") as hora, DATE_FORMAT(created_at, "%i") as minutos')
        ->where('tipo', 'entrada')
        ->where('id_alumno', $alumno->carnet)
        ->whereBetween('created_at', ['2023-10-02', '2023-10-05'])->get();

        //ALGORITMO PARA OBTENER LUNES Y VIERNES PARA OBTENER DATOS DE UNA SEMANA PARA LA ESTADÍSTICA
        /* $diaSemana = date("w");
        # Calcular el tiempo (no la fecha) de cuándo fue el inicio de semana
        $tiempoDeInicioDeSemana = strtotime("-" . ($diaSemana-1) . " days"); # Restamos -X days
        $fechaInicioSemana = date("Y-m-d", $tiempoDeInicioDeSemana);
        $tiempoDeFinDeSemana = strtotime("+" . 4 . " days", $tiempoDeInicioDeSemana);
        $fechaFinSemana = date("Y-m-d", $tiempoDeFinDeSemana); */

        return $asistencia;
    }

    public function estadisticaHoraSalida(Request $request){
        $alumno = DB::table('alumno')->where('gsuite', $request->correo)->first();

        $asistencia = DB::table('asistencias')
        ->selectRaw('DATE_FORMAT(created_at, "%W") as dia, DATE_FORMAT(created_at, "%H") as hora, DATE_FORMAT(created_at, "%i") as minutos')
        ->where('tipo', 'salida')
        ->where('id_alumno', $alumno->carnet)
        ->whereBetween('created_at', ['2023-10-02', '2023-10-05'])->get();

        //ALGORITMO PARA OBTENER LUNES Y VIERNES PARA OBTENER DATOS DE UNA SEMANA PARA LA ESTADÍSTICA
        /* $diaSemana = date("w");
        # Calcular el tiempo (no la fecha) de cuándo fue el inicio de semana
        $tiempoDeInicioDeSemana = strtotime("-" . ($diaSemana-1) . " days"); # Restamos -X days
        $fechaInicioSemana = date("Y-m-d", $tiempoDeInicioDeSemana);
        $tiempoDeFinDeSemana = strtotime("+" . 4 . " days", $tiempoDeInicioDeSemana);
        $fechaFinSemana = date("Y-m-d", $tiempoDeFinDeSemana); */

        return $asistencia;
    }
}
