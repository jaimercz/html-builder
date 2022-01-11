<?php

declare(strict_types=1);

namespace JamesRCZ\HtmlBuilder;

class HtmlForm extends HtmlBuilder
{
    protected static ?HtmlForm $form = null;
    protected ?HtmlBuilder $fieldset;


    final public function __toString()
    {
        $this->addContent($this->fieldset);
        return $this->render();
    }

    public static function create(
        string $tag = 'form',
        int|string|HtmlBuilder $content = null,
        string|array $attributes = []
    ): HtmlForm {
        self::$form             = new self('form');
        self::$form->tag        = 'form';
        self::$form->fieldset   = HtmlBuilder::create('fieldset');

        self::$form->attributes = self::parseAttributes($attributes);
        if(!self::$form->getAttribute('method')) {
            self::$form->setAttribute('method', "post");
        }

        return self::$form;
    }

    public function addElement(
        array $elements,
        string|array $elementAttributes = [],
        string|array $labelAttributes = []
    ) {
        $label      = $elements[0];
        $element    = $elements[1];
        $elementAttributes ?
            $element->setAttributes(self::parseAttributes($elementAttributes)) : false;
        $elementId  = uniqid(
            preg_replace(
                "/[^a-zA-Z]/i",
                "-",
                strtolower(
                    $element->getAttribute('name')
                )
            ) . "_"
        );
        $labelTag   = HtmlBuilder::create(
            'label',
            $label,
            [
                'for' => $elementId
            ]
        );
        $labelAttributes ?
            $labelTag->setAttributes(self::parseAttributes($labelAttributes)) : false;
        $row     = Html::div(null, $elements[2] ?? [])
            ->addContent($labelTag)
            ->addContent($element->id($elementId));
        $this->fieldset->addContent($row);
        return $this;
    }

    public function button(string $value, string|array $attributes = null) {
        $btn = Html::create('button', $value, $attributes);
        $this->fieldset->addContent($btn);
        return $this;
    }

}
