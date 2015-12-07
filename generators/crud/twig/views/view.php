<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator aayaresko\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams(\aayaresko\gii\Generator::TEMPLATE_TYPE_TWIG);
?>
{{ use('/yii/widgets/DetailView') }}
{% set title = model.<?= $generator->getNameAttribute() ?> %}
{{ set(this, 'title', title) }}
{% if not this.params.breadcrumbs %}
{{ set(this, 'params', this.params|merge({'breadcrumbs': []})) }}
{% endif %}
{% set breadcrumbs = this.params.breadcrumbs %}
{% set breadcrumbs = breadcrumbs|merge([{'label': <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url': path(['index'])}]) %}
{% set breadcrumbs = breadcrumbs|merge([title]) %}
{{ set(this, 'params', this.params|merge({'breadcrumbs': breadcrumbs})) }}
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <h1>{{ html.encode(this.title) }}</h1>
    <p>
        <a href="{{ path('update', {<?= $urlParams ?>}) }}" class="btn btn-primary">{{ <?= $generator->generateString('Update') ?> }}</a>
        <a href="{{ path('delete', {<?= $urlParams ?>}) }}" class="btn btn-danger" data-confirm="{{ <?= $generator->generateString('Are you sure you want to delete this item?') ?> }}" data-method="post">{{ <?= $generator->generateString('Delete') ?> }}</a>
    </p>
    {{ detail_view_widget({
            'model': model,
            'attributes': [
<?php
    if (($tableSchema = $generator->getTableSchema()) === false) {
        foreach ($generator->getColumnNames() as $name) {
            echo "                '" . $name . "',\n";
        }
    } else {
        foreach ($generator->getTableSchema()->columns as $column) {
            $format = $generator->generateColumnFormat($column);
            echo "                '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
?>
            ]
        })
    }}
</div>