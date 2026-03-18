<?php

namespace app\modules\core\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * GroupsSearch represents the model behind the search form of `app\modules\core\models\Groups`.
 */
class CuratorGroupsSearch extends GroupsSearch
{
    protected function ExtraSearchFilters(ActiveQuery $query)
    {
        parent::ExtraSearchFilters($query);

        $curatorId = Yii::$app->user->id;
        
        $query->andFilterWhere(['=', '`groups`.`group_curator_id`', Yii::$app->user->id]);
    }
}
