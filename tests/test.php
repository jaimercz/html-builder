<?php

declare(strict_types=1);

use JamesRCZ\HtmlBuilder\Html;
use JamesRCZ\HtmlBuilder\HtmlBuilder;
use JamesRCZ\HtmlBuilder\HtmlTable;
use JamesRCZ\HtmlBuilder\functions;

require_once "../vendor/autoload.php";

$html = HtmlBuilder::create('html');

$head = HtmlBuilder::create('head');
$head->addContent(HtmlBuilder::create(
    'link',
    null,
    [
        'rel' => "stylesheet",
        'href' => "./../dist/app.css"
    ]
));
$head->addContent(HtmlBuilder::create(
    'meta',
    null,
    [
        'name'    => "viewport",
        'content' => "width=device-width, initial-scale=1.0"
    ]
));
$head->addContent(HtmlBuilder::create(
    'title',
    "Html Builder Test Page"
));

$footer = HtmlBuilder::create(
    'footer',
    "This is the footer",
    'text-center text-blue-400 border-t'
);

$body = HtmlBuilder::create('body');
$body->addContent(
    Html::div("This is the Body!")
);

$table = HtmlTable::create('table', null, 'border text-center mx-auto my-5');
$table->addContent(HtmlBuilder::create('caption', "Simple Table"));
$table->addRow(["Header 1","Header 2"], 'header');
$table->addRow(["Cell 1","Cell 2"]);
$body->addContent($table);


$table2 = HtmlTable::build(
    [
        ["Cell 1", Html::div("Cell 2", 'text-yellow-400')],
        ["Cell 3", "Cell 4"]
    ],
    [["Header 1",Html::div("Header 2")]],
    [["Footer Cell 1","Footer Cell 2"]],
)->addClass("border text-center mx-auto my-5");
$table2->setColumnAttributes(2, 'text-red-500');
$body->addContent($table2);

$body->addContent(Html::p(_("A paragraph")));
$body->addContent(p("OOOOO"));

$form = Html::form([
    [
        _("Label 1"),
        Html::input('fist namE', ['value'=>1000]),
        'text-red-200'
    ],
    [_("Label 2"), Html::input('second'), 'grid grid-cols-2 text-red-800 text-right'],
    [_("Label 3"), Html::select([1,2]), 'grid grid-cols-2 my-2'],
    [
        Html::span(null, 'w-1/3 inline-block border-4'),
        Html::span("Here")
    ]
], 'p-2 m-2 shadow');
$body->addContent($form);

$ul = HtmlBuilder::create('ul');
$li = ["A", 1, 2, "C", Html::span("List element")];
$ul->addContentArray($li, 'li');
$body->addContent($ul);

$body->addContent($footer);

// Present the page
$html->addContent($head);
$html->addContent($body);
echo $html;
