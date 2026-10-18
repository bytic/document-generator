<?php
declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Letters\Actions\Finder;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\Entities\HasRepository;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use ByTIC\DocumentGenerator\Letters\Models\LetterTrait;
use ByTIC\DocumentGenerator\Letters\Models\LettersTrait;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;
use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\Record;

/**
 *
 */
class GetOrCreateLetterByParent extends Action
{
    use HasSubject;
    use HasRepository;

    protected bool $createIfMissing = false;

    public function andCreate(bool $createIfMissing = true): self
    {
        $this->createIfMissing = $createIfMissing;

        return $this;
    }

    /**
     * @return LetterTrait|false
     */
    public function handle()
    {
        if (!$this->subject instanceof Record) {
            return false;
        }

        $subject = $this->getSubject();
        /** @var LettersTrait $letters */
        $type = $subject->getManager()->getMorphName();
        $type = inflector()->singularize($type);
        $letter = $letters->getByItem($type, (int)$subject->id);

        if ($letter || !$this->createIfMissing) {
            return $letter;
        }

        $letter = $letters->getNew();
        $letter->id_item = $subject->id;
        $letter->type = $type;
        $letter->insert();

        return $letter;
    }

    protected function generateRepository(): RecordManager
    {
        return DocumentGeneratorModels::letters();
    }
}
