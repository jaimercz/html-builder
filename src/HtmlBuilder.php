<?php

declare(strict_types=1);

namespace JamesRCZ\HtmlBuilder;

class HtmlBuilder
{
    protected static ?HtmlBuilder $instance = null;
    protected ?string $tag                  = null;
    protected ?array $attributes            = [];
    protected ?array $contents              = [];
    protected static array $tagArray        = [
        'a',
        'article',
        'b',
        'blockquote',
        'body',
        'button',
        'caption',
        'dd',
        'div',
        'dl',
        'dt',
        'fieldset',
        'footer',
        'form',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'head',
        'header',
        'html',
        'i',
        'label',
        'li',
        'nav',
        'ol',
        'option',
        'p',
        'script',
        'section',
        'select',
        'span',
        'table',
        'tbody',
        'td',
        'textarea',
        'tfoot',
        'th',
        'thead',
        'title',
        'tr',
        'tt',
        'ul',
        'video',
    ];
    protected static array $nonClosingTagArray = [
        'area',
        'base',
        'br',
        'col',
        'hr',
        'img',
        'input',
        'link',
        'meta',
        'param',
        'source',
    ];

    protected static function parseAttributes(string|array $attributes): array
    {
        if (is_array($attributes)) {
            return $attributes;
        } else {
            return ['class' => $attributes];
        }
    }

    protected static function parseContent($content)
    {
        if (is_string($content)) {
            $string = preg_replace(
                "/<script.*?>(.*)?<\/script>/im",
                "$1",
                $content
            );
            return $string;
        } elseif (is_int($content)) {
            return $content;
        } else {
            /* return $content; */
            if (is_a($content, 'JamesRCZ\HtmlBuilder\HtmlBuilder')) {
                return $content;
            } else {
                return null;
            }
        }
    }

    protected function render(): string
    {
        if (in_array($this->tag, self::$nonClosingTagArray)) {
            if ($this->contents) {
                $this->attributes ['value'] = implode($this->contents);
            }
            $string = sprintf(
                "<%s %s />",
                $this->tag,
                implode(" ", array_map(
                    function ($v, $a) {
                        return $a . '="' .$v.'"';
                    },
                    $this->attributes,
                    array_keys($this->attributes),
                ))
            );
        } else {
            $string = sprintf(
                "<%s%s>%s</%s>",
                $this->tag,
                $this->attributes ?
                " " . implode(" ", array_map(
                    function ($v, $a) {
                        return true === $v ? $a : $a . '="' .$v.'"';
                    },
                    $this->attributes,
                    array_keys($this->attributes),
                )) : null,
                implode($this->contents),
                $this->tag,
            );
        }
        return $string;
    }

    public static function create(
        string $tag,
        int|string|HtmlBuilder $content = null,
        string|array $attributes = []
    ): HtmlBuilder {
        self::$instance          = new self($tag);
        self::$instance->tag     = in_array(
            strtolower($tag),
            self::$tagArray
        ) || in_array(
            strtolower($tag),
            self::$nonClosingTagArray
        ) ?
        strtolower($tag) : throw new \ErrorException(_("Invalid tag!"));

        $content ?
            self::$instance->contents [] = self::parseContent($content) : false;

        self::$instance->attributes = self::parseAttributes($attributes);

        return self::$instance;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function addClass(string $class)
    {
        $this->mergeAttribute('class', $class);
        return $this;
    }

    public function addContent($content, ?string $child = null)
    {
        if (
            isset($this->contents[0]) &&
            is_a($this->contents[0], 'JamesRCZ\HtmlBuilder\HtmlBuilder') &&
            $child === $this->contents[0]->tag
        ) {
            $this->contents[0]->addContent($content);
        } else {
            $this->contents [] = self::parseContent($content);
        }
        return $this;
    }

    public function addContentArray(
        array $contents,
        string $tag,
        string|array $attributes = []
    ) {
        foreach ($contents as $content) {
            $this->addContent(
                HtmlBuilder::create($tag, $content, $attributes)
            );
        }
        return $this;
    }

    public function getAttribute(string $attribute)
    {
        return $this->attributes [$attribute] ?? '';
    }

    public function hasClass(string $class): bool
    {
        $regex = '/(^|\s)' . preg_quote($class, '/') . '(\s|$)/';
        return (bool) preg_match(
            $regex,
            empty($this->attributes['class']) ?
                '' : $this->attributes ['class']
        );
    }

    public function id(string $id)
    {
        $this->setAttribute('id', $id);
        return $this;
    }

    public function mergeAttribute(string $attribute, string $value)
    {
        if (isset($this->attributes[$attribute])) {
            $classes = preg_split(
                "/\s/",
                $this->attributes[$attribute],
                0,
                PREG_SPLIT_NO_EMPTY
            );
            $addClasses = preg_split(
                "/\s/",
                $value,
                0,
                PREG_SPLIT_NO_EMPTY
            );
            $this->setAttribute(
                $attribute,
                implode(" ", array_unique(array_merge($classes, $addClasses)))
            );
        } else {
            $this->setAttribute($attribute, $value);
        }
    }

    public function removeAttribute(string $attribute)
    {
        unset($this->attributes[$attribute]);
        return $this;
    }

    public function removeClass(string $class): bool
    {
        if ($this->hasClass($class)) {
            $classes = preg_split(
                "/\s/",
                $this->attributes['class'],
                0,
                PREG_SPLIT_NO_EMPTY
            );
            $classes = array_filter(
                $classes,
                function ($e) use ($class) {
                    return $e != $class;
                }
            );
            if (empty($classes)) {
                $this->removeAttribute('class');
            } else {
                $this->setAttribute('class', implode(' ', $classes));
            }
            return true;
        }
        return false;
    }

    public function setAttribute(string $attribute, string $value = null)
    {
        $this->attributes [$attribute] = $value;
        return $this;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }
}
