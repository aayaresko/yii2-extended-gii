<?php
/**
 * Created by PhpStorm.
 * User: aayaresko
 * Date: 05.12.15
 * Time: 6:20
 *
 * @author Andrey Yaresko <aayaresko@gmail.com>
 */

namespace aayaresko\gii;

use yii\helpers\VarDumper;
use yii\helpers\Json;

/**
 * Class FormItemsFacade
 * Manage form items, depending on specified file type.
 *
 * File type determine:
 * * template file extension (in witch current form is)
 * * witch format to use for newly created form item
 * Support only twig-files or regular php-files at this time.
 *
 * @package aayaresko\gii
 */
class FormItemsFacade
{
    /**
     * Create new form item for depending on specified file type.
     *
     * File extension determine on specified value of `$file_type`.
     * For twig-files generate:
     *  form.field(model, 'attribute').name(value, options)
     * Value and options are automatically converted into a Json-like string.
     * For php-files generate:
     *  form->field($model, 'attribute')->name(value, options)
     * Value and options are automatically converted into an array-like string.
     *
     * @param string $attribute form item attribute
     * @param array $value form item default value|values of attribute
     * @param int $file_tpe extension of the current file
     * @param null|string $name form item input type (if any)
     * @param array $options form item additional options
     * @return string new form item for specified file extension
     */
    public static function generateField($attribute, $value = [], $file_tpe = Generator::TEMPLATE_TYPE_PHP, $name = null, $options = [])
    {
        switch ($file_tpe) {
            case Generator::TEMPLATE_TYPE_TWIG;
                $delimiter = '.';
                $field_string = "form{$delimiter}field(model, '{$attribute}')";
                //$options_container = '{' . preg_replace('|\=>|', ':', $options) . '}';
                $string_formatter = new Json();
                $method = 'encode';
                break;
            default:
                $delimiter = '->';
                $field_string = "\$form{$delimiter}field(\$model, '{$attribute}')";
                //$options_container = "[{$options}]";
                $string_formatter = new VarDumper();
                $method = 'export';
        }

        if ($name) {
            $field_string = $field_string . $delimiter . "{$name}";

            $options_container = [];

            if ($value) {
                array_push($options_container, $string_formatter::$method($value));
            }
            if ($options) {
                array_push($options_container, $string_formatter::$method($options));
            }

            if ($options_container) {
                $options_container = preg_replace('|"|', "'", implode(', ', $options_container));
                $field_string = "{$field_string}({$options_container})";
            } else {
                $field_string = "{$field_string}()";
            }

        }

        return $field_string;
    }
}