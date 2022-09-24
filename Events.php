<?php

/**
 * Peter Zieseniss
 * Copyright (C) 2022
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 */

namespace humhub\modules\social_stats;

use Yii;
use yii\helpers\Url;
use humhub\modules\ui\menu\MenuLink;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\modules\admin\permissions\ManageModules;
use yii\db; 
use yii\db\Connection; 
use yii\db\Query; 
use yii\db\Command; 


class Events extends \yii\base\BaseObject{
	
	public static function onAdminMenuInit($event){
		
		if (!Yii::$app->user->can(ManageModules::class)) {
			return;
			}
		
		/** @var AdminMenu $menu */
		$menu = $event->sender;
		$menu->addEntry(new MenuLink([
			'label' => Yii::t('SocialStatsModule.base', 'Social Stats'),
			'url' => Url::to(['/social_stats/main/index']),
			//'group' => 'manage',
			'icon' => 'bar-chart',
			'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'social_stats' && Yii::$app->controller->id == 'admin'),
			'sortOrder' => 700,
			]));
		
		}
	
	public static function onDailyCronRun(){
		
		$TodaysDate=date("Y-m-d"); 
		
		// Logins, Posts, Comments, Likes, Follows
		
		$ReadLogins=Yii::$app->db->createCommand("SELECT COUNT(last_login) AS Logins 
				FROM user 
				WHERE (last_login >= (NOW() - INTERVAL 1 DAY));")->queryScalar(); 
		
		$ReadPosts=Yii::$app->db->createCommand("SELECT COUNT(updated_at) AS Posts 
				FROM post 
				WHERE (updated_at >= (NOW() - INTERVAL 1 DAY));")->queryScalar(); 
		
		$ReadComments=Yii::$app->db->createCommand("SELECT COUNT(updated_at) AS Comments 
				FROM comment 
				WHERE (updated_at >= (NOW() - INTERVAL 1 DAY));")->queryScalar(); 
		
		$ReadLikes=Yii::$app->db->createCommand("SELECT COUNT(updated_at) AS Likes 
				FROM `like` 
				WHERE (updated_at >= (NOW() - INTERVAL 1 DAY));")->queryScalar(); 
		
		$ReadFollows=Yii::$app->db->createCommand("SELECT COUNT(created_at) AS Follows 
				FROM notification 
				WHERE (created_at >= (NOW() - INTERVAL 1 DAY) AND source_class=\"humhub\\\\modules\\\\user\\\\models\\\\Follow\");")->queryScalar(); 
		
		/* {x:'2022-09-08', y:360}, */
		
		$DailyDataUpdate_cmd=Yii::$app->db->createCommand("INSERT INTO social_stats(x_value, y_value, category) VALUES 
			(:Xval,:Yval,:Categ);"); 
		
		/* Logins */
		$DailyDataUpdate_cmd->bindValues([':Xval'=>$TodaysDate,':Yval'=>$ReadLogins,':Categ'=>'Logins'])->query(); 
		
		/* Posts */
		$DailyDataUpdate_cmd->bindValues([':Xval'=>$TodaysDate,':Yval'=>$ReadPosts,':Categ'=>'Posts'])->query(); 
		
		/* Comments */
		$DailyDataUpdate_cmd->bindValues([':Xval'=>$TodaysDate,':Yval'=>$ReadComments,':Categ'=>'Comments'])->query(); 
		
		/* Likes */
		$DailyDataUpdate_cmd->bindValues([':Xval'=>$TodaysDate,':Yval'=>$ReadLikes,':Categ'=>'Likes'])->query(); 
		
		/* Follows */
		$DailyDataUpdate_cmd->bindValues([':Xval'=>$TodaysDate,':Yval'=>$ReadFollows,':Categ'=>'Follows'])->query(); 
		}
	
	}




