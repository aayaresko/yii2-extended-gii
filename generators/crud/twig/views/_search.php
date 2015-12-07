<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator aayaresko\gii\generators\crud\Generator */
?>
{{ use('/yii/widgets/ActiveForm') }}
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">
    {% set form = active_form_begin({
            'action': ['index'],
            'method': 'get',
        })
    %}

<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count < 6) {
        echo "    {{ {$generator->generateActiveSearchField($attribute)}|raw }}\n\n";
    } else {
        echo "    {# {$generator->generateActiveSearchField($attribute)}|raw #}\n\n";
    }
}
?>
    <div class="form-group">
        <input type="submit" value="{{ <?= $generator->generateString('Search') ?> }}" class="btn btn-primary">
        <input type="reset" value="{{ <?= $generator->generateString('Reset') ?> }}" class="btn btn-default">
    </div>
    {{ active_form_end() }}
</div>