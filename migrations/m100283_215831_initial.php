<?php

//use yii\db\Schema;
//use yii\db\Migration;
use humhub\components\Migration;

class m100283_215831_initial extends Migration{
	
	public function up(){
		# If social_stats table already exists don't try to create it
		if ($this->db->schema->getTableSchema('social_stats', true) !== null) {
			return true;
		}
		else
		{
			$this->createTable('social_stats', [
				'id' => 'pk',
				'x_value' => 'varchar(28) NULL',
				'y_value' => 'int(11) NULL',
				'category' => 'varchar(28) NULL',
				], '');
			$this->safeCreateIndex('category','social_stats','category',false);
		}
		}

	public function down(){
		echo "my_initial_social_stats does not support migration down.\n";
		return false;
		}
}
