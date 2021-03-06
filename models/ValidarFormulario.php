<?php 
namespace app\models;
use Yii;
use yii\base\model;

class ValidarFormulario extends model{
	public $nombre;
	public $email;

	public function rules(){
		return [
			['nombre', 'required', 'message' => 'Campo Requerido'],
			['nombre', 'match', 'pattern' => "/^.{2,50}$/", 'message' => 'Mínimo 2 y maximo 50 caracteres'],
			['nombre', 'match', 'pattern' => "/^.[a-z]+$/i", 'message' => 'solo se aceptan caracteres alfabeticos'],
			['email', 'required', 'message' => 'debe ingresar un email'],
			['email', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'Mínimo 5 y maximo 80 caracteres'],
			['email', 'email', 'message' => 'Formato no válido'],

		];
	}

	public function attributeLabels(){

		return [
				'nombre' => 'Nombre:',
				'email' => 'Email',
		];
	}



}

?>