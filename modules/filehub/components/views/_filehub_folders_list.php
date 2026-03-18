<?php

use app\modules\filehub\models\FilehubFolders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/** @var \yii\data\ActiveDataProvider $dataProvider */

echo ListView::widget([
    'dataProvider'  => $dataProvider,
    'layout'        => "{items}\n{pager}",
    'itemView' => function (FilehubFolders $model, $key, $index) {
        $folderHref = Html::a($model->folder_title, [Url::to('/filehub/filehub-folders/view'), 'id' => $model->id], [
            'data-pjax' => 0,
        ]);

        echo "
            <span class=\"actions-list__item-icon\"><i class=\"bi bi-folder\"></i></span>
            <span class=\"actions-list__item-text\">{$folderHref}</span><br>
        ";
    }
]);