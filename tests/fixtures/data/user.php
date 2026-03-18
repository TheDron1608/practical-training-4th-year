<?php

use app\modules\core\models\User;

$userPasswordHash = '$2y$13$crj3mL/XhAxTKwKpJKewI.2sdrX385/ejB8E4SXzY0c.a3l620Npy';
$userAdminAuthKey = 'v-N79kiPC1TGB1kdXSCdLLAtLqSY_Ts_Ma1ZrfAc2uoOlOf_1XnJPgP88PKuAt_LrnZRbmeqolil8Bj1AAUxnM0cvygIdmWqLZ-gUwGQQmHFvPiZfyyj-UI1NXMlMiPR';

$createdAt = 1672963122;
$updatedAt = 1672963122;
$lastVisitAt = 1672963121;

return [
    'user0' => [
        'avatar_id'             => null,
        'user_f'                => 'Admin',
        'user_i'                => 'Admin I',
        'user_o'                => 'Admin O',
        'email'                 => 'admin@mail.ru',
        'access_token'          => null,
        'auth_key'              => $userAdminAuthKey,
        'password_hash'         => $userPasswordHash,
        'password_reset_token'  => null,
        'about'                 => null,
        'options'               => null,
        'status'                => User::STATUS_ACTIVE,
        'created_at'            => $createdAt,
        'updated_at'            => $updatedAt,
        'last_visit_at'         => $lastVisitAt,
    ]
];