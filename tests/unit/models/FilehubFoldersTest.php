<?php

namespace tests\unit\models;

use app\modules\filehub\models\FilehubFolders;
use app\tests\fixtures\FilehubFoldersFixture;
use app\tests\fixtures\UserFixture;
use Codeception\Test\Unit;

class FilehubFoldersTest extends Unit
{
    private int $_userId = 1;
    private int $_folderId = 1;

    protected $tester;
    
    /*protected function _before()
    {

    }*/

    /*protected function _after()
    {

    }*/

    public function _fixtures()
    {
        return [
            'user'              => UserFixture::class,
            'filehub_folders'   => FilehubFoldersFixture::class,
        ];
    }

    public function testFilehubFolderCreate()
    {
        $data = [
            'folder_title'  => 'TEST',
        ];

        $model = new FilehubFolders();
        $this->assertTrue( $model->setFolder($data, $this->_userId, null, null, false, '') );
    }

    public function testFilehubFolderUpdate()
    {
        $data = [
            'folder_title'  => 'TEST UPDATE',
        ];

        $model = FilehubFolders::findOne($this->_folderId);
        $this->assertTrue( $model->setFolder($data, $this->_userId, null, null, true, '') );
    }
}