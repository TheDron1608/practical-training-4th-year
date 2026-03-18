<?php

use app\modules\core\models\CoreFiles;
use yii\helpers\Html;
use yii\widgets\ListView;

/** @var \yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var string $defaultClass */

echo ListView::widget([
    'dataProvider'  => $dataProvider,
    'layout'        => "{items}\n{pager}",
    'itemView' => function (CoreFiles $model, $key, $index) {
        $fileHref = Html::a($model->file_title, [$model->file_patch], [
            'target'    => '_blank',
            'data-pjax' => 0,
        ]);

        echo $this->renderFile(Yii::getAlias('@app') . '/modules/filehub/components/views/_file_card.php', [
            'fileHref'  => $fileHref,
            'fileSize'  => $model->file_size,
        ]);
    }
]);