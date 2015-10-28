<?php 
	namespace app\models;
	use Yii;
	use yii\base\model;

	class FormSearch extends model{
		public $q;

		public function rules(){
			return [
				["q", "match", "pattern" => "/^[0-9a-záéíóú\s]+$/i", "message" => "Se aceptan solo caracteres alfanumericos"]
			];
		}

		public function attributeLabels(){
			return [
				'q' => "Buscar:",
			];
		}

	}

?>