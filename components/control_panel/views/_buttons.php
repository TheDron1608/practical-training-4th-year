<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var array $links */
/** @var array $linksBlocks */
/** @var string $class */
/** @var string $linksClass */

if (!isset($class))
{
    $class = 'col-sm-4';
}

if (!isset($linksClass))
{
    $linksClass = 'text-href-style';
}

?>

<div class="row">

    <?php

        if (!empty($links) && is_array($links))
        {
            foreach ($links as $link)
            {
                $href = Html::a(
                    $this->renderFile(Yii::getAlias('@app') . '/components/cards/views/_form_card_mini.php', [
                        'title' => $link['title'],
                        'class' => 'mb-3'
                    ]),

                    [Url::to($link['href'])],

                    [
                        'class' => $linksClass,
                    ]
                );

                echo "<div class=\"{$class}\">{$href}</div>";
            }
        }
        else if (!empty($linksBlocks) && is_array($linksBlocks))
        {
            foreach ($linksBlocks as $linkBlock)
            {
                echo <<<HERE
                    <div class="{$linkBlock['block-class']}">
                        <h5>{$linkBlock['title']}</h5>
                        <hr>
                        <div class="row d-flex align-content-between">
                HERE;

                if ( !empty($linkBlock['items']) && is_array($linkBlock['items']) )
                {
                    foreach ($linkBlock['items'] as $item)
                    {
                        $class = $item['class'] ?? '';

                        $href = Html::a(
                            $this->renderFile(Yii::getAlias('@app') . '/components/cards/views/_form_card_mini.php', [
                                'title' => $item['title'],
                                'class' => 'mb-3'
                            ]),

                            [Url::to($item['href'])],

                            [
                                'class' => $linksClass,
                            ]
                        );

                        echo "<div class=\"{$class}\">{$href}</div>";

                    }
                }

                echo <<<HERE
                        </div>
                    </div>
                HERE;

            }
        }

    ?>

</div>