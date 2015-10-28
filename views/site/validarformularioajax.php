<?php  
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<h1>Validar Formulario Ajax</h1>
<h3><?= $msg ?></h3>

<?php $form = ActiveForm::begin([
	"method" => "post",
	"id" => "formulario",
	"enableClientValidation" => false,
	"enableAjaxValidation" => true,
	]);
?>

<div class="form-group">
	<?= $form->field($model, "nombre")->input("text") ?>
</div>

<div class="form-group">
	<?= $form->field($model, "email")->input("email") ?>
</div>

<?= Html::submitButton("Enviar", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>