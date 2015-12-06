<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator aayaresko\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
?>
{{ use(<?= $generator->indexWidgetType === 'grid' ? "'/yii/grid/GridView'" : "'/yii/widgets/ListView'" ?>) }}
{% set title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?> %}
{{ set(this, 'title', title) }}
{% if not this.params.breadcrumbs %}
{{ set(this, 'params', this.params|merge({'breadcrumbs': []})) }}
{% endif %}
{% set breadcrumbs = this.params.breadcrumbs %}
{% set breadcrumbs = breadcrumbs|merge([title]) %}
{{ set(this, 'params', this.params|merge({'breadcrumbs': breadcrumbs})) }}
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <h1>{{ html.encode(this.title) }}</h1>
<?php if(!empty($generator->searchModelClass)): ?>
<?php $string = "include('_search.twig', {'model': searchModel})"; ?>
    <?= ($generator->indexWidgetType === 'grid' ? "{# $string #}" : "{{ $string }}") ?>
<?php endif; ?>

    <p>
        <a href="{{ path(['create']) }}" class="btn btn-success">{{ <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?> }}</a>
    </p>
<?php if ($generator->indexWidgetType === 'grid'): ?>
    {{ grid_view_widget({
            'dataProvider': dataProvider,
            <?= !empty($generator->searchModelClass) ? "'filterModel': searchModel,\n" : "\n" ?>
                <?= "'columns': ["; ?>

                {'class': '\\yii\\grid\\SerialColumn'},
<?php
$count = 0;
$hidden_fields = [];
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "\n                '{$name}',";
        } else {
            array_push($hidden_fields, "'{$name}'");
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        $field_string = $column->name . ($format === 'text' ? "" : ":" . $format);
        if (++$count < 6) {
            echo "\n                '{$field_string}',";
        } else {
            array_push($hidden_fields, "'{$field_string}'");
        }
    }
}
?>


                {'class': '\\yii\\grid\\ActionColumn'},
            ],
        })
    }}
<?= !empty($hidden_fields) ? "{#\n" . implode(",\n", $hidden_fields) . "\n#}\n" : ''?>
<?php else: ?>
    {{ list_view_widget({
            'dataProvider': dataProvider,
            'itemOptions': {'class': 'item'},
            'viewParams': {'nameAttribute': nameAttribute, 'urlParams': <?= $urlParams ?>}
            'itemView': '_view.twig'
        })
    }}
<?php endif; ?>
</div>