<?php

//use yii\db\Schema;
//use yii\db\Migration;
use humhub\components\Migration;

class m100283_215831_initial extends Migration{
	
	public function up(){
		$this->createTable('social_stats', [
			'id' => 'pk',
			'x_value' => 'varchar(28) NULL',
			'y_value' => 'int(11) NULL',
			'category' => 'varchar(28) NULL',
			], '');
		$this->safeCreateIndex('category','social_stats','category',false);
		$this->safeCreateIndex('last_login','user','last_login',false);
		$this->safeCreateIndex('updated_at','post','updated_at',false);
		$this->safeCreateIndex('updated_at','comment','updated_at',false);
		$this->safeCreateIndex('updated_at','like','updated_at',false);
		$this->safeCreateIndex('SourceCreated','notification',['created_at', 'source_class'],false);
		}

	public function down(){
		echo "my_initial_social_stats does not support migration down.\n";
		return false;
		}
}
