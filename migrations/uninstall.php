<?php

use humhub\components\Migration;

class uninstall extends Migration{
	public function up(){
		// Intentionally not dropping the social_stats table to preserve historical data.
		// To remove the table manually execute `DROP TABLE social_stats;` on your database
		// or uncomment the line below and uninstall the addon through HumHub
		# $this->dropTable('social_stats');
		}
	public function down(){
		echo "uninstall does not support migration down.\n";
		return false;
		}
	}
