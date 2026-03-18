<?php

namespace app\modules\admin\controllers;

use app\modules\core\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /* ===== Панель управления. ===== */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    // ----- TODO: ДОПИСАТЬ.
    /* ===== Статистика по сайту. ===== */
    public function actionStatistics(): string
    {
        return $this->render('statistics');
    }
}