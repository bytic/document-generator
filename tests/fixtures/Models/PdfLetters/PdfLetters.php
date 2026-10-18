<?php

namespace ByTIC\DocumentGenerator\Tests\Fixtures\Models\Letters;

use ByTIC\DocumentGenerator\Letters\Models\Letters\LettersTrait;
use Nip\Records\RecordManager;
use Nip\Records\Traits\AbstractTrait\RecordsTrait as AbstractRecordsTrait;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Letter
 * @package ByTIC\DocumentGenerator\Tests\Fixtures\Models\Letters
 */
class Letters extends RecordManager
{
    use LettersTrait;
    use SingletonTrait;

    /**
     * @inheritdoc
     */
    public function getPrimaryKey()
    {
        return 'id';
    }

    public function generateTable()
    {
        return 'letter_letters';
    }

    /**
     * @param $type
     * @return AbstractRecordsTrait
     */
    public function getParentManagerFromType($type)
    {
        // TODO: Implement getParentManagerFromType() method.
    }

    /**
     * @return string
     */
    protected function getCustomFieldsManagerClass()
    {
        // TODO: Implement getCustomFieldsManagerClass() method.
    }
}
