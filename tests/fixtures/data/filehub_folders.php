<?php

use app\modules\filehub\models\FilehubFolders;

$userId = 1;
$parentId = null;

return [
    'folder0'   => [
        'folder_owner_id'   => $userId,
        'folder_parent_id'  => $parentId,
        'folder_title'      => 'TEST FOLDER',
        'folder_about'      => null,
        'folder_code'       => FilehubFolders::CODE_MY,
        'status'            => FilehubFolders::STATUS_ACTIVE,
        'created_at'        => 17503948,
    ]
];