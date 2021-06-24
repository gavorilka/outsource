<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

//use app\models\Orders;
use app\models\Performers;
use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    /**
     * @param int $count
     */
    public function actionGenerateUsers($count = 1)
    {
        for ($i = 0; $i < $count; $i++) {
            $user = new User();
            $user->login = "user" . time('s') . rand(0, 10);
            $user->password = "pass" . time('s') . rand(10, 20);
            $user->save();

            echo "User $user->id created\n";

            $this->createPerformers('Иванов Иван Адамович', '1,2', $user->id, 'ivanov');
            $this->createPerformers('Сидоров Иван Ильич', '3,2,5', $user->id, 'sidorov');
            $this->createPerformers('Халамов Пётр Александрович', '7', $user->id, 'halamov');
            $this->createPerformers('Камушкин Георгий Петрович', '1,2,3,4', $user->id, 'kamaskin');
            $this->createPerformers('Раскольников Фёдор Иванович', '6', $user->id, 'raskolnikov');
            $this->createPerformers('Адамов Лаврентий Павлович', '4,5', $user->id, 'adamov');
        }
    }

        private function createPerformers($fio, $profession, $user, $pic)
	    {
	        $per = new Performers();
	        $per->fio = $fio;
	        $per->user = $user;
	        $per->profession = $profession;
	        $per->photo = 'user_'.$pic.'.png';

	        $per->save();
	        echo "\tuser $per->id created\n";

	        //this->create($per->id, $order);
	    }


}
