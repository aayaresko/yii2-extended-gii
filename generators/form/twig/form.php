<?php
/**
 * This is the template for generating an action view file.
 */

/* @var $this yii\web\View */
/* @var $generator aayaresko\gii\generators\form\Generator */

?>
{{ use('/yii/widgets/ActiveForm') }}
<div class="<?= str_replace('/', '-', trim($generator->viewName, '_')) ?>">
    {% set form = active_form_begin() %}
<?php foreach ($generator->getModelAttributes() as $attribute): ?>
        {{ form.field(model, '<?= $attribute ?>')|raw }}<?= "\n" ?>
<?php endforeach; ?>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="{{ <?= $generator->generateString('Submit') ?> }}">
    </div>
    {{ active_form_end() }}
</div>