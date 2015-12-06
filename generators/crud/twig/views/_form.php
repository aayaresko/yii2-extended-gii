<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator aayaresko\gii\generators\crud\Generator */
/* @var $model \yii\db\ActiveRecord */

$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}
?>
{{ use('/yii/widgets/ActiveForm') }}
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    {% set form = active_form_begin() %}
<?php foreach ($generator->getColumnNames() as $attribute) {
if (in_array($attribute, $safeAttributes)) {
    echo "\n        {{ " . $generator->generateActiveField($attribute) . "|raw }}\n";
    }
} ?>

    <div class="form-group">
        <input type="submit" value="{{ model.isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Update') ?> }}" class="{{ model.isNewRecord ? "btn btn-success" : "btn btn-primary" }}">
    </div>
    {{ active_form_end() }}
</div>