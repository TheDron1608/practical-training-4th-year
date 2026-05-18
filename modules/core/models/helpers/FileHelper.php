<?php

namespace app\modules\core\models\helpers;

use yii\base\Model;
use yii\helpers\StringHelper;

class FileHelper extends Model
{
    /* ===== Получить содержание файла. ===== */
    public static function getFileContent(string $filePatch, ?string $separator = null, bool $isFileUnlink = false): array|false
    {
        try
        {
            $file = file($filePatch);

            if (isset($separator))
            {
                if (is_array($file))
                {
                    foreach ($file as &$item)
                    {
                        $item = StringHelper::explode($item, ';', true);
                    }
                }
            }

            if ($isFileUnlink)
            {
                unlink($filePatch);
            }
        }
        catch (\Exception $e)
        {
            return false;
        }

        return $file;
    }
    
    public static function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}