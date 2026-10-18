<?php

namespace ByTIC\DocumentGenerator\Bundle\Frontend\Controllers;

use ByTIC\DocumentGenerator\Letters\Models\Letters\LettersTrait;
use ByTIC\DocumentGenerator\Letters\Models\Letters\LetterTrait;
use ByTIC\DocumentGenerator\Bundle\Frontend\Controllers\AbstractControllerTrait as BundleFrontendAbstractControllerTrait;

/**
 * Trait FrontendLetterControllerTrait
 * @package ByTIC\DocumentGenerator\Letters
 *
 * @method LetterTrait getModelFromRequest()
 * @method LettersTrait getModelManager()
 */
trait LetterControllerTrait
{
    use BundleFrontendAbstractControllerTrait;

    public function generate()
    {
        $recipient = $this->getLetterRecipientFromRequest();

        /** @var LetterTrait $diploma */
        $diploma = $this->getLetterFromRecipient($recipient);

        $diploma->addDownload($recipient);

        $diploma->download($recipient);
        die();
    }

    /**
     * @return \Nip\Records\AbstractModels\Record
     */
    abstract protected function getLetterRecipientFromRequest();

    abstract protected function getLetterFromRecipient($recipient);
}
