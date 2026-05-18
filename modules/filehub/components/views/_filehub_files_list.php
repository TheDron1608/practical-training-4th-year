<?php

use app\modules\core\models\CoreFiles;
use yii\widgets\ListView;

/** @var \yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var string $defaultClass */
?>

<?= ListView::widget([
    'dataProvider'  => $dataProvider,
    'layout'        => "{items}\n{pager}",
    'itemView' => function (CoreFiles $model) {
        echo $this->renderFile(Yii::getAlias('@app') . '/modules/filehub/components/views/_file_card.php', [
            'model' => $model
        ]);
    }
]); ?>