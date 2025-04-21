<?php

namespace App\Enums;

class LessonEnum
{
    const Youtube = 1;
    const Vimeo = 2;
    const VideoFile = 3;
    const GoogleDrive = 4;
    const DocumentFile = 5;
    const Text = 6;
    const ImageFile = 7;
    const IframeEmbed = 8;

    public static function getValues(): array
    {
        return [
            'Youtube' => self::Youtube,
            'Vimeo' => self::Vimeo,
            'VideoFile' => self::VideoFile,
            'GoogleDrive' => self::GoogleDrive,
            'DocumentFile' => self::DocumentFile,
            'Text' => self::Text,
            'ImageFile' => self::ImageFile,
            'IframeEmbed' => self::IframeEmbed,
        ];
    }

    // return only value with array like ['Youtube', 'Vimeo', 'VideoFile', 'GoogleDrive', 'DocumentFile', 'Text', 'ImageFile', 'IframeEmbed']
    public static function getKeysName(): array
    {
        return array_keys(self::getValues());
    }
}
