<?php

namespace ByTIC\DocumentGenerator\Bundle\Admin\Controllers;

use ByTIC\DocumentGenerator\Letters\Actions\Finder\GetLetterByParent;
use ByTIC\DocumentGenerator\Letters\Actions\ImportFieldsFrom;
use ByTIC\DocumentGenerator\Letters\Models\LettersTrait;
use ByTIC\DocumentGenerator\Letters\Models\LetterTrait;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use ByTIC\MediaLibrary\Media\Media;
use Nip\Records\Record;
use Nip\Records\RecordManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Trait AdminLetterControllerTrait
 * @package ByTIC\DocumentGenerator\Letters
 *
 * @method LetterTrait getModelFromRequest()
 * @method LettersTrait getModelManager()
 */
trait LetterControllerTrait
{
    use AbstractControllerTrait;

    /**
     * @var string
     */
    protected $letterType;

    /**
     * @var RecordManager
     */
    protected $parentManager;

    /**
     * @var Record
     */
    protected $parent;

    public function view()
    {
        $letter = $this->viewCheckItem();

        parent::view();

        $this->forms['letter'] = $letter->getForm();
        $this->payload()->with(
            [
                'letter_fields' => $letter->getCustomFields(),
                'letter' => $letter,
                'title' => DocumentGeneratorModels::letters()->getLabel('title'),
            ]
        );
    }

    public function upload()
    {
        if ($this->getRequest()->files->has('letter')) {
            $parent = $this->getParent();
            if ($parent) {
                /** @var UploadedFile $uploadedFile */
                $uploadedFile = $this->getRequest()->files->get('letter');

                if (!$uploadedFile->isValid()) {
                    $this->flashRedirectLetter($parent, $uploadedFile->getErrorMessage(), 'error');
                    return;
                }

                $letter = $this->getModelFromRequest();
                if (!$letter) {
                    $letter = $this->newLetterRecordFromItemType($parent, $this->getLetterType());
                }

                $result = $letter->uploadFromRequest($uploadedFile);

                if ($result instanceof Media) {
                    $this->flashRedirectLetter($parent, $this->getModelManager()->getMessage('add'));
                } else {
                    $letter->delete();
                    $this->flashRedirectLetter($parent, $result, 'error');
                }
                return;
            }
            return;
        }
    }

    public function downloadExample()
    {
        $letter = $this->getModelFromRequest();
        $item = $letter->getItem();

        if ($letter->hasFile()) {
            $letter->downloadExample();
            return;
        }

        $this->flashRedirectLetter($item, $this->getModelManager()->getMessage('no-file'), 'error');
    }

    public function downloadBlank()
    {
        $letter = $this->getModelFromRequest();
        $parent = $letter->getItem();
        if ($letter->hasFile()) {
            $letter->downloadBlank();
            return;
        }

        $this->flashRedirectLetter($parent, $this->getModelManager()->getMessage('no-file'), 'error');
    }

    public function importFrom()
    {
        $letter = $this->getModelFromRequest();

        $from = $this->checkForeignModelFromRequest(
            $this->getRequest()->query('from'),
            'from_id'
        );
        if (!$from) {
            $this->flashRedirectLetter($letter, $this->getModelManager()->getMessage('no-from'), 'error');
            return;
        }

        $fromLetter = GetLetterByParent::byItemType($from->getManager()->getMorphName(), $from->id);

        if (!$fromLetter) {
            $this->flashRedirectLetter($letter, $this->getModelManager()->getMessage('no-letter'), 'error');
            return;
        }

        $count = ImportFieldsFrom::for($letter)->from($fromLetter);
        if ($count > 0) {
            $_type = 'success';
            $messageSlug = 'success';
        } else {
            $messageSlug = 'no-fields';
        }

        $this->flashRedirectLetter($letter, $this->getModelManager()->getMessage($messageSlug), $_type);
    }

    /**
     * @param Record $parent
     * @param $message
     * @param string $type
     */
    protected function flashRedirectLetter($parent, $message, $type = 'success')
    {
        $this->flashRedirect(
            $message,
            $this->getLettersPageUrl($parent),
            $type,
            $this->getLettersPageController($parent)
        );
    }

    /**
     * @param Record $parent
     * @return mixed
     */
    protected function getLettersPageUrl($parent)
    {
        return $parent->getURL();
    }

    /**
     * @param Record $parent
     * @return mixed
     */
    protected function getLettersPageController($parent)
    {
        return $parent->getManager()->getController();
    }

    /**
     * @return mixed
     */
    protected function viewCheckItem()
    {
        $letter = $this->getModelFromRequest();

        if (!$letter) {
            $this->redirect($this->getModelManager()->getUploadURL($this->getRequest()->query->all()));
        }
        return $letter;
    }

    /**
     * @param $item
     * @param $type
     * @return LetterTrait|Record
     */
    protected function newLetterRecordFromItemType($item, $type)
    {
        $letter = $this->newLetterRecord();
        $letter->id_item = $item->id;
        $letter->type = $type;
        $letter->insert();
        return $letter;
    }

    /**
     * @return Record|LetterTrait
     */
    protected function newLetterRecord()
    {
        return $this->getModelManager()->getNew();
    }

    /**
     * @return RecordManager
     */
    protected function getParentManager()
    {
        return $this->parentManager;
    }

    /**
     * @return Record
     */
    protected function getParent()
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    protected function getLetterType()
    {
        return $this->letterType;
    }

    /**
     * Called before action
     */
    protected function parseRequestLetter()
    {
        if ($this->getRequest()->get('id_item') && $this->getRequest()->get('type')) {
            $this->checkRequestForParent();
        } else {
            $this->checkRequestForItem();
        }
    }

    protected function checkRequestForParent()
    {
        $this->letterType = $this->getRequest()->get('type');
        $this->parentManager = $this->getModelManager()->getParentManagerFromType($this->getRequest()->get('type'));
        $this->parent = $this->parentManager->findOne($this->getRequest()->get('id_item'));
        if ($this->parent) {
            $this->setModelFromRequest($this->getModelManager()->getByItem($this->letterType, $this->parent->id));
        }
    }

    protected function checkRequestForItem()
    {
        $letter = $this->getModelFromRequest();
        $this->checkRequestSetFromLetter($letter);
    }

    /**
     * @param LetterTrait $letter
     */
    protected function checkRequestSetFromLetter($letter)
    {
        $this->letterType = $letter->type;
        $this->parent = $letter->getItem();
        $this->parentManager = $letter->getItemsManager();
    }

    /**
     * @inheritdoc
     */
    protected function setBreadcrumbs()
    {
        $this->call('setClassBreadcrumbs', $this->parentManager->getController(), false);
        $this->call('setItemBreadcrumbs', $this->parentManager->getController(), false, [$this->parent]);

        $this->setClassBreadcrumbs();
    }
}
