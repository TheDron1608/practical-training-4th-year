<?php

/** @var mixed $fileHref */
/** @var \app\modules\core\models\CoreFiles $model */
/** @var int $fileSize */

?>

<div class="file">
    <div class="file-icon__wrapper">
        <span class="file-icon"><i class="bi bi-file-earmark-arrow-down"></i></span>
    </div>
    <div class="file-content">
        <h5 class="file-content__heading"><?= $fileHref ?></h5>
        <p class="file-content__dscrp"><?= $fileSize ?> BIT</p>
    </div>
</div>