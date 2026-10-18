<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\PdfWriter\Actions\Finder;

use Bytic\Actions\Behaviours\Entities\HasRepository;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use ByTIC\DocumentGenerator\PdfWriter\Models\LetterTrait;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use Nip\Records\AbstractModels\RecordManager;

/**
 *
 */
class GetLetterByParent extends \ByTIC\Actions\Action
{
    use HasSubject;
    use HasRepository;

    protected $type;
    protected $item_id;

    public static function byItemType(string $type, int|string $idItem): static
    {
        $action = new static();
        $action->type = $type;
        $action->item_id = $idItem;

        return $action;
    }

    public function handle()
    {
        $types = [$this->type];
        $types[] = inflector()->singularize($this->type);
        /** @var LetterTrait[] $letters */
        $letters = $this->getRepository()->findByParams(
            [
                'where' => [
                    ['id_item = ?', $this->item_id],
                    ['type IN ?', $types],
                ],
                'order' => [['id', 'DESC']],
            ]
        );


        if (count($letters) < 1) {
            return false;
        }

        $return = false;
        foreach ($letters as $letter) {
            if ($letter->hasFile() && !$return) {
                $return = $letter;
            } else {
//                    $item->delete();
            }
        }

        return $return;
    }

    protected function generateRepository(): RecordManager
    {
        return DocumentGeneratorModels::letters();
    }
}


