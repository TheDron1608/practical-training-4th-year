<?php

use app\modules\core\models\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var \app\modules\core\models\CoreFiles $model */
$filePath = Html::encode($model['file_title'], $model['file_patch']);

?>

<div class="file">
    <a href="<?= Url::to(['/filehub/download-file', 'id' => $model['id']], 'https') ?>" class="file-icon__wrapper" download>
        <span class="file-icon"><i class="bi bi-file-earmark-arrow-down"></i></span>
    </a>
    <div class="file-content">
        <h5 class="file-content__heading"><?= $filePath ?></h5>
        <p class="file-content__dscrp"><?= FileHelper::formatSizeUnits($model['file_size']) ?></p>
    </div>
</div>