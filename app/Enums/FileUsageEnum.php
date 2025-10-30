<?php

namespace App\Enums;

enum FileUsageEnum: string
{
    case Avatar = 'avatar';
    case Attachment = 'attachment';
    case Source = 'source';
    case Figma = 'figma';
    case CV = 'cv';
    case Temp = 'temp';
    case Other = 'other';
}
