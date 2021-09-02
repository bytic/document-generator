<?php

namespace ByTIC\DocumentGenerator\PdfLetters\Models\Fields\Attributes;

use Nip\Utility\Str;

class TextTransform
{
    public const NAME = "text_transform";

    public const NONE = "none";
    public const CAPITALIZE = "capitalize";
    public const UPPERCASE = "uppercase";
    public const LOWERCASE = "lowercase";

    public const OPTIONS = [self::NONE, self::CAPITALIZE, self::UPPERCASE, self::LOWERCASE];

    /**
     * @param string $value
     * @param null $transform
     * @return mixed|string
     */
    public static function transform($value, $transform = null)
    {
        if (empty($transform) || $transform == null || $transform == static::NONE) {
            return $value;
        }
        if ($transform === static::UPPERCASE) {
            return Str::upper($value);
        }
        if ($transform === static::LOWERCASE) {
            return Str::lower($value);
        }
        return $value;
    }
}