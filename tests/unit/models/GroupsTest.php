<?php
namespace tests\unit\models;

use app\modules\core\models\Groups;
use app\tests\fixtures\GroupsFixture;
use app\tests\fixtures\UserFixture;
use Codeception\Test\Unit;

class GroupsTest extends Unit
{
    protected $tester;

    protected int $userId = 1;
    protected int $curatorId = 1;
    protected int $groupId = 1;
    
    /*protected function _before()
    {

    }*/

    /*protected function _after()
    {

    }*/

    public function _fixtures()
    {
        return [
            'user'      => UserFixture::class,
            'groups'    => GroupsFixture::class,
        ];
    }

    public function testGroupCreate()
    {
        $data = [
            'Groups' => [
                'group_curator_id'  => $this->curatorId,
                'group_title'       => 'Group 0',
            ],
        ];

        verify( (new Groups())->setGroup($data, $this->userId) )->true();

        $data = [
            'Groups' => [
                'group_curator_id'  => 999,
                'group_title'       => 'Group NO',
            ],
        ];

        verify( (new Groups())->setGroup($data, $this->userId) )->false();
    }

    public function testGroupUpdate()
    {
        $data = [
            'Groups' => [
                'group_title'       => 'Group Update',
            ],
        ];

        verify( (Groups::findOne($this->groupId))->setGroup($data, $this->userId, true) )->true();
    }
}