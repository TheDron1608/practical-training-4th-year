<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\modules\core\models\Menu;
use app\modules\core\models\User;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Breadcrumbs;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

$getUserId = Yii::$app->user->id ?? false;

if ($getUserId)
{
    $userRoles = User::getUserRoles($getUserId);
}

if (isset(Yii::$app->user->identity->avatar_id))
{
    $img = Yii::$app->user->identity->userAvatar->file_patch;
}
else
{
    $img = Yii::getAlias('@web') . "/img/no_avatar.png";
}

$menu = Menu::getMenuElements($userRoles ?? false, $getUserId);

$sidebar = $menu['sideBare'];

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<div class="app">
    <header class="app-header header">
        <div class="header-logo">
            <?= Html::a(Yii::t('app', ''), [Yii::$app->homeUrl], [
                'class' => 'actions-list__link'
            ]) ?>
        </div>
        <div class="header-content">
            <div class="header-content__wrapper">
                <div id="toggle-sidebar" class="header-content__item header-content__item-active">
                    <svg class="header-content__icon header-content__icon-active bi bi-list" xmlns="http://www.w3.org/2000/svg" width="16"
                         height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                    </svg>
                </div>
            </div>
            <div class="header-content__wrapper">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <div class="header-content__logout m-3">
                        <?= Html::a("Выйти (" . (Yii::$app->user->identity->userFio . ")"), ["/core/user/logout"], ['class' => 'link link-light']) ?>
                    </div>
                    <div class="header-content__item header-content__item-active">
                        <?= Html::a("<img src=\"{$img}\" alt=\"\" class=\"avatar-img\">", [Url::to('/core/user/view')], [
                            'class' => 'avatar avatar__middle avatar__round avatar__border',
                            ]) ?>
                </div>
                <?php else: ?>
                    <div class="header-content__logout m-3">
                        <?= Html::a("Войти", ["/core/user/login"], ['class' => 'link link-light']) ?>
                    </div>
                    <div class="header-content__logout m-3">
                        <?= Html::a("Зарегестрироваться", ["/core/user/signup"], ['class' => 'link link-light']) ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </header>
    <aside id="sidebar" class="app-sidebar sidebar">
        <ul class="actions-list">

            <?php
                foreach ($sidebar as $item)
                {
                    if ($item[Menu::KEY_CODE] == Menu::CODE_DROPDOWN)
                    {
                        echo "
                            <li data-sidebardropdown=\"true\" class=\"actions-list__title actions-list__title-nested\">
                                <div class=\"actions-list__item-wrapper\">
                                    <span class=\"actions-list__item-icon\">{$item[Menu::KEY_ICON]}</span>
                                    <span class=\"actions-list__item-icon\">{$item[Menu::KEY_LABEL]}</span>
                                </div>
                                <span class=\"actions-list__item-icon\"><i class=\"bi bi-arrow-bar-down\"></i></span>
                            </li>
                        ";

                        echo "<ul class=\"actions-list__sublist __nested-list\">";

                            if (!empty($item[Menu::KEY_ITEMS]))
                            {
                                foreach ($item[Menu::KEY_ITEMS] as $val)
                                {
                                    $href = Html::a($val[Menu::KEY_LABEL], $val[Menu::KEY_URL], [
                                        'class' => 'actions-list__link',
                                    ]);

                                    echo <<<HERE
                                        <li class="actions-list__item actions-list__sublist-item">
                                            <div class="actions-list__item-wrapper">
                                                <span class="actions-list__item-icon">{$val[Menu::KEY_ICON]}</span>
                                                {$href}
                                            </div>
                                        </li>
                                    HERE;
                                }
                            }

                        echo "</ul>";
                    }
                    else
                    {
                        $href = Html::a($item[Menu::KEY_LABEL], $item[Menu::KEY_URL], [
                            'class' => 'actions-list__link',
                        ]);

                        echo <<<HERE
                            <li class="actions-list__item">
                                <div class="actions-list__item-wrapper">
                                    <span class="actions-list__item-icon">{$item[Menu::KEY_ICON]}</span>
                                    {$href}
                                </div>
                            </li>
                        HERE;
                    }
                }
            ?>

        </ul>
    </aside>
    <main class="app-content container" id="main">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </main>
    <footer class="footer" id="footer">
        <span>
            <?= Html::a('KADI-Company', 'https://kadi-company.ru/', [
                'target' => '_blank',
            ]) ?>
        </span>
    </footer>
    <div class="backdrop-custom" id="backdrop-custom"></div>
</div>

<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>