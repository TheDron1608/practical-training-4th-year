<?php

/** @var \yii\web\View $this */
/** @var \yii\base\DynamicModel $model */
/** @var array $getFolders */
/** @var null|int $folderId */

?>

<div class="upload-files">

    <div class="card">
        <div class="card-body">
            <?= $this->render('_form_upload', [
                'model'         => $model,
                'getFolders'    => $getFolders,
                'folderId'      => $folderId ?? null,
            ]) ?>
        </div>
    </div>

</div>