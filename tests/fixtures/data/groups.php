<?php

use app\modules\core\models\Groups;

$authorId = 1;
$curatorId = 1;

$createdAt = 1672963122;
$updatedAt = 1672963122;

return [
    'group0' => [
        'group_author_id'           => $authorId,
        'group_curator_id'          => $curatorId,
        'group_qualification_id'    => null,
        'group_title'               => 'Group 0',
        'group_about'               => null,
        'group_options'             => null,
        'status'                    => Groups::STATUS_ACTIVE,
        'created_at'                => $createdAt,
        'updated_at'                => $updatedAt,
    ]
];