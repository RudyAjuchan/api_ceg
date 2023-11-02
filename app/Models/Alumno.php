<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Alumno
 * 
 * @property int $carnet
 * @property string|null $nombres
 * @property string|null $apellidos
 * @property Carbon|null $fecha_nac
 * @property string|null $genero
 * @property string|null $plan
 * @property string|null $gsuite
 * @property string|null $correo_alumno
 * @property string|null $observacion
 * @property string|null $solvente1
 * @property string|null $solvente2
 * @property string|null $solvente3
 * @property string|null $solvente4
 * @property int|null $activo
 * @property int|null $id_grado
 * @property Carbon|null $fecha_inscripcion
 * @property int|null $gsuite_creado
 * @property int|null $id_clase_ingles
 * @property string|null $clase_especial
 * @property string|null $password
 * 
 * @property Grado|null $grado
 * @property Collection|Encargado[] $encargados
 * @property Collection|NotaActividad[] $nota_actividads
 * @property Collection|NotaActividadIngle[] $nota_actividad_ingles
 * @property Collection|NotaCurso[] $nota_cursos
 * @property Collection|NotaCursoIngle[] $nota_curso_ingles
 * @property Collection|Reporte[] $reportes
 *
 * @package App\Models
 */
class Alumno extends Model
{
	protected $table = 'alumno';
	protected $primaryKey = 'carnet';
	public $timestamps = false;

	protected $casts = [
		'fecha_nac' => 'datetime',
		'activo' => 'int',
		'id_grado' => 'int',
		'fecha_inscripcion' => 'datetime',
		'gsuite_creado' => 'int',
		'id_clase_ingles' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'nombres',
		'apellidos',
		'fecha_nac',
		'genero',
		'plan',
		'gsuite',
		'correo_alumno',
		'observacion',
		'solvente1',
		'solvente2',
		'solvente3',
		'solvente4',
		'activo',
		'id_grado',
		'fecha_inscripcion',
		'gsuite_creado',
		'id_clase_ingles',
		'clase_especial',
		'password'
	];

	public function grado()
	{
		return $this->belongsTo(Grado::class, 'id_grado');
	}

	public function encargados()
	{
		return $this->belongsToMany(Encargado::class, 'asignar_alumno_encargado', 'id_alumno', 'id_encargado')
					->withPivot('id_alumno_encargado');
	}

	public function nota_actividads()
	{
		return $this->hasMany(NotaActividad::class, 'id_alumno');
	}

	public function nota_actividad_ingles()
	{
		return $this->hasMany(NotaActividadIngle::class, 'id_alumno');
	}

	public function nota_cursos()
	{
		return $this->hasMany(NotaCurso::class, 'id_alumno');
	}

	public function nota_curso_ingles()
	{
		return $this->hasMany(NotaCursoIngle::class, 'id_alumno');
	}

	public function reportes()
	{
		return $this->hasMany(Reporte::class, 'id_alumno');
	}
}
