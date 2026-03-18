<?php
namespace tests\unit\models;

use app\modules\edu\models\EduQualifications;
use app\tests\fixtures\EduQualificationsFixture;
use Codeception\Test\Unit;

class EduQualificationsTest extends Unit
{
    protected $tester;

    private int $_qualificationId = 1;
    
    /*protected function _before()
    {

    }*/

    /*protected function _after()
    {

    }*/

    public function _fixtures()
    {
        return [
            'edu-qualifications' => EduQualificationsFixture::class,
        ];
    }

    public function testMultipleCreateQualifications()
    {
        $qualifications = ['test0', 'test1'];

        $this->assertEquals(true, EduQualifications::multipleCreateQualifications($qualifications));
    }

    public function testSetEduQualifications()
    {
        $data = [
            'qualification_title'   => 'TEST SET',
            'qualification_about'   => null,
        ];

        $model = new EduQualifications();
        $this->assertTrue($model->setEduQualifications($data, false, ''));
    }

    public function testUpdateQualification()
    {
        $data = [
            'qualification_title'   => 'TEST UPDATE',
            'qualification_about'   => null,
        ];

        $model = EduQualifications::findOne($this->_qualificationId);
        $this->assertTrue($model->setEduQualifications($data, false, ''));
    }
}