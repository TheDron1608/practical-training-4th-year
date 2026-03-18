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
}