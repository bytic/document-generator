<?php

namespace ByTIC\DocumentGenerator\Tests\PdfLetters\Models\Fields;

use ByTIC\DocumentGenerator\Tests\AbstractTest;
use ByTIC\DocumentGenerator\Tests\Fixtures\Models\PdfLetters\Fields\FieldRecord;

class FieldTraitTest extends AbstractTest
{
    public function testGetPageFallsBackToAbsoluteYPosition()
    {
        $field = $this->newFieldRecord();
        $field->y = 320;

        self::assertSame(2, $field->getPage());
        self::assertSame(23.0, $field->getEditorYPosition());
    }

    public function testFillFromEditorDataNormalizesColorAndSerializesEditorData()
    {
        $field = $this->newFieldRecord();
        $field->fillFromEditorData(
            [
                'field' => 'recipient_name',
                'x' => 120.25,
                'y' => 42.5,
                'page' => 3,
                'size' => 16,
                'align' => 'center',
                'color' => '#336699',
                'textTransform' => 'uppercase',
            ]
        );

        $editorData = $field->toEditorArray();

        self::assertSame('recipient_name', $field->field);
        self::assertSame('51,102,153', $field->color);
        self::assertSame(3, $editorData['page']);
        self::assertSame(42.5, $editorData['y']);
        self::assertSame('uppercase', $editorData['textTransform']);
    }

    private function newFieldRecord(): FieldRecord
    {
        return new class() extends FieldRecord {
            public function __construct()
            {
                $this->metadata = new class() {
                    private array $data = [];

                    public function set($key, $value): void
                    {
                        $this->data[$key] = $value;
                    }

                    public function get($key, $default = null)
                    {
                        return $this->data[$key] ?? $default;
                    }
                };
            }

            public function getName()
            {
                return (string)$this->field;
            }

            public function getTypeValue()
            {
                return 'text';
            }
        };
    }
}
