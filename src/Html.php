<?php

/**
 * SGLMS HTML Builder
 *
 * PHP Version 8.1
 *
 * @category SGLMS_Library
 * @package  HTMLBuilder
 * @author   Jaime C. Rubin-de-Celis <james@sglms.com>
 * @license  MIT (https://sglms.com/license)
 * @link     https://sglms.com
 **/

declare(strict_types=1);

namespace JamesRCZ\HtmlBuilder;

/**
 * SGLMS HTML
 *
 * PHP Version 8.1
 *
 * @category SGLMS_Library
 * @package  HTMLBuilder
 * @author   Jaime C. Rubin-de-Celis <james@sglms.com>
 * @license  MIT (https://sglms.com/license)
 * @link     https://sglms.com
 **/
class Html extends HtmlBuilder
{
    /**
     * Div Tag
     *
     * @param string|\JamesRCZ\HtmlBuilder\HtmlBuilder $content    Content
     * @param string|array                             $attributes Tag Attributes
     *
     * @return \JamesRCZ\HtmlBuilder\HtmlBuilder
     **/
    public static function div(
        string|HtmlBuilder $content = null,
        string|array $attributes = []
    ): HtmlBuilder {
        $html = self::create('div', $content, $attributes);
        return $html;
    }

    /**
     * Hn Tag
     *
     * @param int                                      $n          Heading Level
     * @param string|\JamesRCZ\HtmlBuilder\HtmlBuilder $content    Content
     * @param string|array                             $attributes Tag Attributes
     *
     * @return \JamesRCZ\HtmlBuilder\HtmlBuilder
     **/
    public static function h(
        int $n,
        ?string $content,
        string|array $attributes = []
    ): HtmlBuilder {
        return self::create('h' . $n, $content, $attributes);
    }

    /**
     * P Tag
     *
     * @param string|\JamesRCZ\HtmlBuilder\HtmlBuilder $content    Content
     * @param string|array                             $attributes Tag Attributes
     *
     * @return \JamesRCZ\HtmlBuilder\HtmlBuilder
     **/
    public static function p(
        string|HtmlBuilder $content = null,
        string|array $attributes = []
    ): HtmlBuilder {
        return self::create('p', $content, $attributes);
    }

    /**
     * Span Tag
     *
     * @param string|\JamesRCZ\HtmlBuilder\HtmlBuilder $content    Content
     * @param string|array                             $attributes Tag Attributes
     *
     * @return \JamesRCZ\HtmlBuilder\HtmlBuilder
     **/
    public static function span(
        string|HtmlBuilder $content = null,
        string|array $attributes = []
    ) {
        $html = HtmlBuilder::create('span', $content, $attributes);
        return $html;
    }

    /**
     * Input Tag
     *
     * @param array        $name       HtmlBuilder Tags
     * @param string|array $attributes Tag Attributes
     *
     * @return \JamesRCZ\HtmlBuilder\HtmlBuilder
     **/
    public static function input(
        string $name,
        string|array $attributes = []
    ): HtmlBuilder {
        $html = HtmlBuilder::create('input', null, $attributes);
        $html->setAttribute('name', $name);
        return $html;
    }

    /**
     * Select Tag
     *
     * @param array        $options    HtmlBuilder Tags
     * @param string|array $attributes Tag Attributes
     * @param mixed        $selected   Selected Option Id
     *
     * @return \JamesRCZ\HtmlBuilder\HtmlBuilder
     **/
    public static function select(
        array $options,
        string|array $attributes = [],
        mixed $selected = null
    ) {
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

    /**
     * Form Tag
     *
     * @param array        $elements          HtmlBuilder Tags
     * @param string|array $attributes        Tag Attributes
     * @param string|array $elementAttributes Tag Attributes
     * @param string|array $labelAttributes   Tag Attributes
     *
     * @return \JamesRCZ\HtmlBuilder\HtmlBuilder
     **/
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

    /**
     * Table Tag
     *
     * @param array             $tableBody       HtmlBuilder Tags
     * @param array             $tableHeader     Tag Attributes
     * @param array             $tableFooter     Tag Attributes
     * @param string|array|null $tableAttributes Tag Attributes
     *
     * @return \JamesRCZ\HtmlBuilder\HtmlBuilder
     **/
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
