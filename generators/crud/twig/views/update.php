<?php

use yii\helpers\Json;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator aayaresko\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams(\aayaresko\gii\Generator::TEMPLATE_TYPE_TWIG);
?>
{% set title = <?= $generator->generateString('Update {modelClass}: ', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?> ~ model.<?= $generator->getNameAttribute() ?> %}
{{ set(this, 'title', title) }}
{% if not this.params.breadcrumbs %}
{{ set(this, 'params', this.params|merge({'breadcrumbs': []})) }}
{% endif %}
{% set breadcrumbs = this.params.breadcrumbs %}
{% set breadcrumbs = breadcrumbs|merge([{'label': <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url': path(['index'])}]) %}
{% set breadcrumbs = breadcrumbs|merge([{'label': model.<?= $generator->getNameAttribute() ?>, 'url': path('view', {<?= $urlParams ?>})}]) %}
{% set breadcrumbs = breadcrumbs|merge([<?= $generator->generateString('Update') ?>]) %}
{{ set(this, 'params', this.params|merge({'breadcrumbs': breadcrumbs})) }}
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">
    <h1>{{ html.encode(this.title) }}</h1>
        {{ include('_form.twig', {
                'model': model,
            })
        }}
</div>