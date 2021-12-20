<?php

declare(strict_types=1);

namespace JamesRCZ\HtmlBuilder;

class Html extends HtmlBuilder
{
    public static function div(string|HtmlBuilder $content = null, string|array $attributes = [])
    {
        $html = HtmlBuilder::create('div', $content, $attributes);
        return $html;
    }

    public static function h(int $n, ?string $content)
    {
        return HtmlBuilder::create('h' . $n, $content);
    }

    public static function p(string|HtmlBuilder $content = null, string|array $attributes = [])
    {
        $html = HtmlBuilder::create('p', $content, $attributes);
        return $html;
    }

    public static function span(string|HtmlBuilder $content = null, string|array $attributes = [])
    {
        $html = HtmlBuilder::create('span', $content, $attributes);
        return $html;
    }

    public static function input(string $name, string|array $attributes = [])
    {
        $html = HtmlBuilder::create('input', null, $attributes);
        $html->setAttribute('name', $name);
        return $html;
    }

    public static function select(array $options, string|array $attributes = [], mixed $selected = null)
    {
        $html = HtmlBuilder::create('select', null, $attributes);
        foreach ($options as $value => $option) {
            $html->addContent(
                HtmlBuilder::create(
                    'option',
                    (string) $option,
                    ['value' => $value] +
                    ($selected == $value ? ['selected' => true] : []),
                )
            );
        }
        return $html;
    }

    public static function form(
        array $elements,
        string|array $attributes = [],
        string|array $elementAttributes = [],
        string|array $labelAttributes   = [],
    ) {
        $form = HtmlForm::create('form', null, $attributes);
        foreach ($elements as $key => $element) {
            $form->addElement($element, $elementAttributes, $labelAttributes);
        }
        return $form;
    }

    public static function table(
        array $tableBody,
        ?array $tableHeader = [],
        ?array $tableFooter = [],
        string|array|null $tableAttributes = []
    ) {
        $table = HtmlTable::build($tableBody, $tableHeader, $tableFooter, $tableAttributes);
        return $table;
    }
}
