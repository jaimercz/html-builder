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

use JamesRCZ\HtmlBuilder\HtmlBuilder;
use JamesRCZ\HtmlBuilder\Html;

function a(
    string|HtmlBuilder $text,
    string|array $attributes = null,
    ?string $href = null
) {
    $a = HtmlBuilder::create('a', $text, $attributes ?? '');
    $href ? $a->setAttribute('href', $href) : false;
    return $a;
}

function div(
    string|HtmlBuilder $text = null,
    string|array $attributes=[]
) {
    return Html::div($text, $attributes);
}

function fa(
    string|array $attributes = []
) {
    return Html::create('i', null, $attributes);
}

function h(
    int $n,
    string|HtmlBuilder $text,
    string|array $attributes = []
) {
    return Html::h($n, $text, $attributes);
}

function i(
    string|array $attributes = []
) {
    return Html::create('i', null, $attributes);
}

function p(
    string|HtmlBuilder $text = null,
    string|array $attributes=[]
) {
    return Html::p($text, $attributes);
}

function span(
    string|HtmlBuilder $text = null,
    string|array $attributes=[]
) {
    return Html::create('span', $text, $attributes);
}
