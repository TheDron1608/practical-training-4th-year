<?php

namespace app\modules\core\models;

use app\modules\edu\models\EduSubjects;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * @property mixed|null user_f
 * @property mixed|null user_i
 * @property mixed|null user_o
 * @property mixed|null email
 * @property string|null about
 * @property mixed|string|null password_hash
 * @property mixed|string|null auth_key
 * @property int|mixed|null last_visit_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_USER_CREATE = 'scenario_user_create';

    const STATUS_ACTIVE     = 10;
    const STATUS_DELETED    = 0;

    const STATUS_ALL = [
        self::STATUS_ACTIVE,
        self::STATUS_DELETED,
    ];

    const ROLE_ADMINISTRATOR    = 'admin';
    const ROLE_CURATOR          = 'curator';
    const ROLE_USER             = 'user';
    const ROLE_TEACHER          = 'teacher';

    const ROLE_ALL = [
        self::ROLE_ADMINISTRATOR,
        self::ROLE_CURATOR,
        self::ROLE_USER,
        self::ROLE_TEACHER,
    ];

    const LOCALIZED_ROLES = [
        User::ROLE_ADMINISTRATOR    => 'Администратор',
        User::ROLE_CURATOR          => 'Куратор',
        User::ROLE_TEACHER          => 'Учитель',
        User::ROLE_USER             => 'Студент',
    ];

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public $avatar;
    public $password;
    public $password_new;
    public $role;

    public function rules()
    {
        return [
            [['user_f', 'user_i', 'email', 'auth_key', 'password_hash'], 'required'],
            [['password', 'role'], 'required', 'on' => self::SCENARIO_USER_CREATE],
            [['avatar_id', 'created_at', 'updated_at', 'last_visit_at'], 'integer'],
            [['user_f', 'user_i', 'user_o'], 'string', 'max' => 50],
            [['email', 'auth_key', 'password_hash', 'access_token', 'snils'], 'string', 'max' => 255],
            [['options'], 'safe'],
            [['user_f', 'user_i', 'user_o', 'email', 'password', 'password_new'], 'trim'],
            [['password', 'password_new'], 'string', 'min' => 6, 'max' => 64],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\modules\core\models\User', 'message' => Yii::t('app', 'Почта уже занята!')],
            ['about', 'string', 'max' => 1500],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => self::STATUS_ALL],
            ['avatar', 'file', 'extensions' => 'jpg, jpeg, png',
                'maxFiles' => 1, 'maxSize' => 50*1024*1024, 'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false],
        ];
    }

    public function getUserAvatar()
    {
        return $this->hasOne(CoreFiles::class, ['id' => 'avatar_id']);
    }

    public function attributeLabels()
    {
        return [
            'user_fio'           => Yii::t('app', 'ФИО'),
            'user_f'             => Yii::t('app', 'Фамилия'),
            'user_i'             => Yii::t('app', 'Имя'),
            'user_o'             => Yii::t('app', 'Отчество'),
            'email'              => Yii::t('app', 'Почта'),
            'about'              => Yii::t('app', 'Обо мне'),
            'password'           => Yii::t('app', 'Пароль'),
            'password_new'       => Yii::t('app', 'Повторить пароль'),
            'role'               => Yii::t('app', 'Роль'),
            'avatar'             => Yii::t('app', 'Аватар'),
            'status'             => Yii::t('app', 'Статус'),
            'created_at'         => Yii::t('app', 'Дата создания'),
            'updated_at'         => Yii::t('app', 'Дата редактирования'),
            'snils'              => Yii::t('app', 'Снилс'),
            'student_group'      => Yii::t('app', 'Группа (Студент)')
        ];
    }

    public static function getStatusTypeAll(): array
    {
        return [
            self::STATUS_ACTIVE     => Yii::t('app', 'Активен'),
            self::STATUS_DELETED    => Yii::t('app', 'Удален'),
        ];
    }

    public static function translateRoles(array $roles)
    {
        return array_map(fn($i) => self::LOCALIZED_ROLES[$i] ?? [$i], $roles);
    }

    /* ===== Получить роли пользователей. ===== */
    public static function getTypeUserRoles(?array $unsetRoles = null): array
    {
        $roles = self::LOCALIZED_ROLES;

        if (!empty($unsetRoles))
        {
            foreach ($unsetRoles as $unsetRole)
            {
                unset($roles[$unsetRole]);
            }
        }

        return $roles;
    }

    /* ===== Получить роли пользователя. ===== */
    public static function getUserRoles(?int $userId = null)
    {
        if (!isset($userId))
        {
            $userId = Yii::$app->user->id;
        }

        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($userId);
        $userRoles = [];

        if (is_array($roles))
        {
            foreach ($roles as $role)
            {
                $userRoles[$role->name] = $role->name;
            }
        }

        return $userRoles;
    }

    /* ===== Получить список пользователей. ===== */
    public static function getUserList(?array $userIds = null, ?string $role = null, ?string $status = self::STATUS_ACTIVE): array
    {
        if ($role)
        {
            $getUserIdsByRole = self::getUserIdsByRole($role);
            if (isset($userIds))
            {
                $userIds = array_merge($userIds, $getUserIdsByRole);
            }
            else
            {
                $userIds = $getUserIdsByRole;
            }
        }

        $userList = self::find()
            ->select([
                'id',
                "CONCAT(`user_f`, ' ', `user_i`, ' ', `user_o`) AS `user_fio`"
            ])
            ->andFilterWhere(['in', 'id', $userIds])
            ->andFilterWhere(['=', 'status', $status])
            ->asArray()
            ->all();

        return ArrayHelper::map($userList, 'id', 'user_fio');
    }

    /* ===== Получить ids пользователей по роли. ===== */
    public static function getUserIdsByRole(string $role): array
    {
        $auth = Yii::$app->authManager;
        return $auth->getUserIdsByRole($role);
    }

    /* ===== Создание пользователей. ===== */
    public static function createUsers(array $users, string $role = self::ROLE_USER)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try
        {
            /* ===== Начало: Создать пользователей. ===== */
            $time = time();
            $arrUsersCreate = [];
            $userEmails = [];
            $usersData = [];
            foreach ($users as $user)
            {
                $userF          = $user['user_f'];
                $userI          = $user['user_i'];
                $userO          = $user['user_o'];
                $userEmail      = $user['user_email'];
                $userPassword   = $user['user_password'] ?? Yii::$app->security->generateRandomString(8);

                $arrUsersCreate[] = [
                    'avatar_id'             => null,
                    'user_f'                => $userF,
                    'user_i'                => $userI,
                    'user_o'                => $userO,
                    'email'                 => $userEmail,
                    'access_token'          => null,
                    'auth_key'              => Yii::$app->security->generateRandomString(128),
                    'password_hash'         => Yii::$app->security->generatePasswordHash($userPassword),
                    'password_reset_token'  => null,
                    'about'                 => null,
                    'options'               => null,
                    'status'                => self::STATUS_ACTIVE,
                    'created_at'            => $time,
                    'updated_at'            => $time,
                    'last_visit_at'         => $time,
                ];

                $userEmails[] = $userEmail;

                $usersData[] = [
                    'user_f'        => $userF,
                    'user_i'        => $userI,
                    'user_o'        => $userO,
                    'user_password' => $userPassword,
                    'user_email'    => $userEmail,
                ];
            }

            if (!empty($arrUsersCreate))
            {
                throw new \Exception('Error No Array');
            }

            if ( !Yii::$app->db->createCommand()
                ->batchInsert(self::tableName(), [], $arrUsersCreate)
                ->execute() ) {
                throw new \Exception('Error No Batch Insert');
            }
            /* ===== Конец: Создать пользователей. ===== */

            /* ===== Начало: Прикрепляем роли к пользователям. ===== */
            if (empty($userEmails))
            {
                throw new \Exception('Error No Emails');
            }

            $userIds = self::find()
                ->select('id')
                ->where(['in', 'email', $userEmails])
                ->column();

            if (!is_array($userIds))
            {
                throw new \Exception('Error No User Ids');
            }

            if (!self::addUsersRole($userIds, $role))
            {
                throw new \Exception('Error No Add Role');
            }
            /* ===== Конец: Прикрепляем роли к пользователям. ===== */
        }
        catch (\Throwable $e)
        {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        return $usersData;
    }

    /* ===== Добавить пользователям роли. ===== */
    public static function addUsersRole(array $userIds, string $role = self::ROLE_USER): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        $auth = Yii::$app->authManager;
        foreach ($userIds as $userId)
        {
            $rbacRole = $auth->getRole($role);
            if (!$auth->assign($rbacRole, $userId))
            {
                $transaction->rollBack();
                return false;
            }
        }

        $transaction->commit();
        return true;
    }

    /* ===== Проверка: Входит ли пользователь в администрацию сайта. ===== */
    public static function isAdministrationSite(int $userId, ?array $userRoles = null, bool $teacherRole = false): bool
    {
        if (!isset($userRoles))
        {
            $userRoles = self::getUserRoles($userId);
        }

        if ( array_key_exists(self::ROLE_ADMINISTRATOR, $userRoles) )
            return true;

        if ( array_key_exists(self::ROLE_CURATOR, $userRoles) )
            return true;

        if ($teacherRole)
        {
            if ( array_key_exists(self::ROLE_TEACHER, $userRoles) )
                return true;
        }

        return false;
    }

    /* ===== Проверка: На определенную роль. ===== */
    public static function isUserRole(int $userId, string $role)
    {
        return Yii::$app->authManager->getAssignment($role, $userId);
    }

    public function getUserFio(): string
    {
        return "{$this->user_f} {$this->user_i} {$this->user_o}";
    }

    /* ===== Создать пользователя. ===== */
    public function createUser(array $data, string $formName = 'User')
    {
        $signupForm = new SignupForm();
        if (!$signupForm->load($data, $formName))
        {
            return false;
        }

        if ($signupForm->signup())
        {
            return true;
        }

        return false;
    }

    /* ===== Редактировать пользователя. ===== */
    public function updateUser(array $data, string $formName = 'User')
    {
        if ( $this->load($data, $formName) )
        {
            $modelCoreFiles = new CoreFiles();
            if ( $modelCoreFiles->file = UploadedFile::getInstance($this, 'avatar') )
            {
                if (isset($this->avatar_id))
                {
                    CoreFiles::deleteFiles([$this->avatar_id]);
                }

                if ( !$modelCoreFiles->upload($this->id, CoreFiles::DIR_UPLOADED_FILES, CoreFiles::CODE_AVATAR) )
                {
                    throw new \Exception('Error No Upload');
                }

                $this->avatar_id = $modelCoreFiles->id;
            }

            if (!empty($this->password) && $this->password !== "")
            {
                if ($this->password !== $this->password_new && strlen($this->password) > 1)
                {
                    return false;
                }

                $this->setPassword($this->password_new);
            }

            return $this->save();
        }

        return false;
    }

    /*****************************************
     * ===== НАЧАЛО: IDENTITY INTERFACE. =====
     * =======================================
     */

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString(128);
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function setPassword(string $password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function getStudentGroup()
    {
        return GroupsUsers::getUserGroups($this->id);
    }

    public function getTeacherSubjects() {
        return $this->hasMany(EduSubjects::class, ['id' => 'subject_id'])
        ->viaTable("edu_subjects_groups", ['teacher_id' => 'id']);
    }

    public function getTeacherSubjectsList()
    {
        $query =
            EduSubjects::find()
            ->innerJoin('subject_qualifications', '`subject_qualifications`.`subject_id` = `edu_subjects`.`id`')
            ->innerJoin('edu_subjects_groups', '`subject_qualifications`.`id` = `edu_subjects_groups`.`subject_qualification_id`')
            ->innerJoin('user', '`edu_subjects_groups`.`teacher_id` = `user`.`id`')
            ->where(['=', '`user`.`id`', $this->id])
            ->select(['`edu_subjects`.`id`', '`edu_subjects`.`subject_title`'])
            ->asArray()
            ->all();

        return ArrayHelper::map($query, 'id', 'subject_title');
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /****************************************
     * ===== КОНЕЦ: IDENTITY INTERFACE. =====
     * ======================================
     */
}
