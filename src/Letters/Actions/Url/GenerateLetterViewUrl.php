<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Letters\Actions\Url;

use Bytic\Actions\Action;
use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;

class GenerateLetterViewUrl extends Action
{

    /**
     * @param $parent
     * @return string|null
     */
    public static function forParent($parent): ?string
    {
        if ($parent === null) {
            return null;
        }
        return DocumentGeneratorModels::letters()->compileURL(
            'view',
            [
                'type' => $parent->getManager()->getMorphName(),
                'id' => $parent->id,
            ]
        );
    }
}