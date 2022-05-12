<?php

declare(strict_types=1);

namespace JamesRCZ\HtmlBuilder;

class HtmlTable extends HtmlBuilder
{
    protected static ?HtmlTable $table = null;
    protected ?HtmlBuilder $thead;
    protected ?HtmlBuilder $tfoot;
    protected ?HtmlBuilder $tbody;
    protected ?HtmlBuilder $tr;


    final public function __toString()
    {
        $this->addContent($this->thead);
        $this->addContent($this->tbody);
        $this->addContent($this->tfoot);
        return $this->render();
    }

    public static function create(
        string $tag = 'table',
        int|float|string|HtmlBuilder $content = null,
        string|array $attributes = []
    ): HtmlTable {
        self::$table          = new self('table');
        self::$table->tag     = 'table';
        self::$table->thead = HtmlBuilder::create('thead');
        self::$table->tbody = HtmlBuilder::create('tbody');
        self::$table->tfoot = HtmlBuilder::create('tfoot');

        self::$table->attributes = self::parseAttributes($attributes);

        return self::$table;
    }

    public static function build(
        array $tbody,
        ?array $thead = [],
        ?array $tfoot = [],
        string|array|null $attributes = []
    ) {
        $table = self::create('table', null, $attributes);
        if ($thead) {
            foreach ($thead as $row) {
                $table->addRow($row, 'header');
            }
        }
        foreach ($tbody as $row) {
            $table->addRow($row);
        }
        if ($tfoot) {
            foreach ($tfoot as $row) {
                $table->addRow($row, 'footer');
            }
        }
        return $table;
    }

    public function addRow(
        array $row,
        ?string $section = 'body'
    ) {
        $this->tr = HtmlBuilder::create('tr');
        $this->tr->addContentArray($row, $section !== 'body' ? 'th' : 'td');
        if ('header' === $section) {
            $this->thead->addContent($this->tr);
        } elseif ('footer' === $section) {
            $this->tfoot->addContent($this->tr);
        } else {
            $this->tbody->addContent($this->tr);
        }
        return $this;
    }

    public function setColumnAttributes(
        int $colNumber           = 1,
        string|array $attributes = [],
        ?bool $includeHeader     = false
    ): HtmlTable {
        foreach ($this->tbody->contents as $tr) {
            $tr->contents [$colNumber - 1]
               ->setAttributes(self::parseAttributes($attributes));
        }
        if ($includeHeader) {
            foreach ($this->thead->contents as $tr) {
                $tr->contents [$colNumber - 1]
                   ->setAttributes(self::parseAttributes($attributes));
            }
        }
        return $this;
    }
}
