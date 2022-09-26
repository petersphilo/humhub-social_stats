<?php

/**
 * Peter Zieseniss
 * Copyright (C) 2022
 * 
 * Please consider making a donation using the button found on the main page of this module; it would help me greatly..
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 */

namespace humhub\modules\social_stats\controllers;

use Yii;
use yii\console\Controller;
use yii\web\Request;

use yii\db; 
use yii\db\Query; 
use yii\db\Command; 
/*
use humhub\modules\admin\permissions\ManageModules; 
if ((!Yii::$app->user->can(ManageModules::class))||($_SESSION['social_stats_sesh']!='MySocialStatsSesh')) {
	return 'This is not the page you are looking for..'; 
	}
*/

class MainController extends \humhub\modules\admin\components\Controller{

	public function behaviors(){
		return [
			'acl' => [
				'class' => \humhub\components\behaviors\AccessControl::className(),
				'adminOnly' => true
				]
			];
		}
	
	
	public function actionIndex(){
		if(Yii::$app->request->post()||Yii::$app->request->get('dlInactiveAccnts')||Yii::$app->request->get('dlHistDataBU')){$this->MyDataRequest(); }
		else{return $this->render('index'); }
		}
	
	
	public function MyDataRequest(){
		
		if(Yii::$app->request->get('dlInactiveAccnts')=='Yes'){
			$MyTabChar="\t"; 
			$dlInactiveAccntsFile='email'.$MyTabChar.'username'/* .$MyTabChar.'previousid' */."\n"; 
			$dlInactiveAccnts_cmd=Yii::$app->db->createCommand("SELECT user.email,user.username 
				FROM user 
				WHERE last_login is null;")->queryAll(); 
			foreach($dlInactiveAccnts_cmd as $dlInactiveAccnts_row){
				$dlInactiveAccntsFile.=$dlInactiveAccnts_row['email'].$MyTabChar.$dlInactiveAccnts_row['username']/* .$MyTabChar.$dlInactiveAccnts_row['previousid'] */."\n";
				}
			echo $dlInactiveAccntsFile; 
			exit;
			}
		
		elseif(Yii::$app->request->get('dlHistDataBU')=='Yes'){
			$MyTabChar="\t"; 
			$dlHistDataBUFile='id'.$MyTabChar.'x_value'.$MyTabChar.'y_value'.$MyTabChar.'category'."\n"; 
			$dlHistDataBU_cmd=Yii::$app->db->createCommand("SELECT id,x_value,y_value,category 
				FROM social_stats;")->queryAll(); 
			foreach($dlHistDataBU_cmd as $dlHistDataBU_row){
				$dlHistDataBUFile.=$dlHistDataBU_row['id'].$MyTabChar.$dlHistDataBU_row['x_value'].$MyTabChar.$dlHistDataBU_row['y_value'].$MyTabChar.$dlHistDataBU_row['category']."\n";
				}
			echo gzencode($dlHistDataBUFile, 6); 
			/* echo $dlHistDataBUFile; */
			exit;
			}
		
		elseif(Yii::$app->request->post('HistoricalDailyData')=='Yes'){
			/* Begin Historical Data */
			// Logins, Posts, Comments, Likes, Follows
			$DailyData_cmd=Yii::$app->db->createCommand("SELECT x_value,y_value 
				FROM social_stats 
				WHERE (category=:Cat) ORDER BY id ASC;"); 
			
			$DailyData['DailyLogins']=[]; 
			$DailyLogins_cmd=$DailyData_cmd->bindValue(':Cat','Logins')->queryAll(); 
			foreach($DailyLogins_cmd as $DailyLogins_row){
				// $DailyLogins.="{x:'".$DailyLogins_row['x_value']."',y:".$DailyLogins_row['y_value']."},";
				array_push($DailyData['DailyLogins'],['x'=>$DailyLogins_row['x_value'],'y'=>$DailyLogins_row['y_value']]);
				}
			
			$DailyData['DailyPosts']=[]; 
			$DailyPosts_cmd=$DailyData_cmd->bindValue(':Cat','Posts')->queryAll(); 
			foreach($DailyPosts_cmd as $DailyPosts_row){
				// $DailyPosts.="{x:'".$DailyPosts_row['x_value']."',y:".$DailyPosts_row['y_value']."},";
				array_push($DailyData['DailyPosts'],['x'=>$DailyPosts_row['x_value'],'y'=>$DailyPosts_row['y_value']]);
				}
			
			$DailyData['DailyComments']=[]; 
			$DailyComments_cmd=$DailyData_cmd->bindValue(':Cat','Comments')->queryAll(); 
			foreach($DailyComments_cmd as $DailyComments_row){
				// $DailyComments.="{x:'".$DailyComments_row['x_value']."',y:".$DailyComments_row['y_value']."},";
				array_push($DailyData['DailyComments'],['x'=>$DailyComments_row['x_value'],'y'=>$DailyComments_row['y_value']]);
				}
			
			$DailyData['DailyLikes']=[]; 
			$DailyLikes_cmd=$DailyData_cmd->bindValue(':Cat','Likes')->queryAll(); 
			foreach($DailyLikes_cmd as $DailyLikes_row){
				// $DailyLikes.="{x:'".$DailyLikes_row['x_value']."',y:".$DailyLikes_row['y_value']."},";
				array_push($DailyData['DailyLikes'],['x'=>$DailyLikes_row['x_value'],'y'=>$DailyLikes_row['y_value']]);
				}
			
			$DailyData['DailyFollows']=[]; 
			$DailyFollows_cmd=$DailyData_cmd->bindValue(':Cat','Follows')->queryAll(); 
			foreach($DailyFollows_cmd as $DailyFollows_row){
				// $DailyFollows.="{x:'".$DailyFollows_row['x_value']."',y:".$DailyFollows_row['y_value']."},";
				array_push($DailyData['DailyFollows'],['x'=>$DailyFollows_row['x_value'],'y'=>$DailyFollows_row['y_value']]);
				}
			/* End Historical Data */
			
			$DailyData['DailyExec']=microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]; 
			
			echo json_encode($DailyData,JSON_FORCE_OBJECT); 
			exit;
			}
		
		elseif(Yii::$app->request->post('GeneralData')=='Yes'){
			/* Begin General Data */
			/*  */
			$GD_ReadLogins_cmd=Yii::$app->db->createCommand("SELECT COUNT(last_login) AS Logins 
				FROM user 
				WHERE (last_login >= (NOW() - INTERVAL :Num DAY));"); 

			$GD_ReadPosts_cmd=Yii::$app->db->createCommand("SELECT COUNT(updated_at) AS Posts 
				FROM post 
				WHERE (updated_at >= (NOW() - INTERVAL :Num DAY));"); 

			$GD_ReadComments_cmd=Yii::$app->db->createCommand("SELECT COUNT(updated_at) AS Comments 
				FROM comment 
				WHERE (updated_at >= (NOW() - INTERVAL :Num DAY));"); 

			$GD_ReadLikes_cmd=Yii::$app->db->createCommand("SELECT COUNT(updated_at) AS Likes 
				FROM `like` 
				WHERE (updated_at >= (NOW() - INTERVAL :Num DAY));"); 

			$GD_ReadFollows_cmd=Yii::$app->db->createCommand("SELECT COUNT(created_at) AS Follows 
				FROM notification 
				WHERE (created_at >= (NOW() - INTERVAL :Num DAY) AND source_class=\"humhub\\\\modules\\\\user\\\\models\\\\Follow\");"); 

			$GeneralData['TotalLogins']=Yii::$app->db->createCommand("SELECT COUNT(last_login) AS TotalLogins 
				FROM user 
				WHERE (last_login >= '2022-08-01');")->queryScalar(); 


			$NumOne=1; 
			$NumSeven=7; 
			$NumThirty=30; 
			$NumQuartY=90; 
			$NumHalfY=180; 

			/* Logins */
			$GeneralData['LoginsOneDay']=$GD_ReadLogins_cmd->bindValue(':Num', $NumOne)->queryScalar(); 
			$GeneralData['LoginsOneWeek']=$GD_ReadLogins_cmd->bindValue(':Num', $NumSeven)->queryScalar(); 
			$GeneralData['LoginsOneMonth']=$GD_ReadLogins_cmd->bindValue(':Num', $NumThirty)->queryScalar(); 
			$GeneralData['LoginsOneQuarterY']=$GD_ReadLogins_cmd->bindValue(':Num', $NumQuartY)->queryScalar(); 
			$GeneralData['LoginsOneHalfY']=$GD_ReadLogins_cmd->bindValue(':Num', $NumHalfY)->queryScalar(); 

			/* Posts */
			$GeneralData['PostsOneDay']=$GD_ReadPosts_cmd->bindValue(':Num', $NumOne)->queryScalar(); 
			$GeneralData['PostsOneWeek']=$GD_ReadPosts_cmd->bindValue(':Num', $NumSeven)->queryScalar(); 
			$GeneralData['PostsOneMonth']=$GD_ReadPosts_cmd->bindValue(':Num', $NumThirty)->queryScalar(); 
			$GeneralData['PostsOneQuarterY']=$GD_ReadPosts_cmd->bindValue(':Num', $NumQuartY)->queryScalar(); 
			$GeneralData['PostsOneHalfY']=$GD_ReadPosts_cmd->bindValue(':Num', $NumHalfY)->queryScalar(); 

			/* Comments */
			$GeneralData['CommentsOneDay']=$GD_ReadComments_cmd->bindValue(':Num', $NumOne)->queryScalar(); 
			$GeneralData['CommentsOneWeek']=$GD_ReadComments_cmd->bindValue(':Num', $NumSeven)->queryScalar(); 
			$GeneralData['CommentsOneMonth']=$GD_ReadComments_cmd->bindValue(':Num', $NumThirty)->queryScalar(); 
			$GeneralData['CommentsOneQuarterY']=$GD_ReadComments_cmd->bindValue(':Num', $NumQuartY)->queryScalar(); 
			$GeneralData['CommentsOneHalfY']=$GD_ReadComments_cmd->bindValue(':Num', $NumHalfY)->queryScalar(); 

			/* Likes */
			$GeneralData['LikesOneDay']=$GD_ReadLikes_cmd->bindValue(':Num', $NumOne)->queryScalar(); 
			$GeneralData['LikesOneWeek']=$GD_ReadLikes_cmd->bindValue(':Num', $NumSeven)->queryScalar(); 
			$GeneralData['LikesOneMonth']=$GD_ReadLikes_cmd->bindValue(':Num', $NumThirty)->queryScalar(); 
			$GeneralData['LikesOneQuarterY']=$GD_ReadLikes_cmd->bindValue(':Num', $NumQuartY)->queryScalar(); 
			$GeneralData['LikesOneHalfY']=$GD_ReadLikes_cmd->bindValue(':Num', $NumHalfY)->queryScalar(); 

			/* Follows */
			$GeneralData['FollowsOneDay']=$GD_ReadFollows_cmd->bindValue(':Num', $NumOne)->queryScalar(); 
			$GeneralData['FollowsOneWeek']=$GD_ReadFollows_cmd->bindValue(':Num', $NumSeven)->queryScalar(); 
			$GeneralData['FollowsOneMonth']=$GD_ReadFollows_cmd->bindValue(':Num', $NumThirty)->queryScalar(); 
			$GeneralData['FollowsOneQuarterY']=$GD_ReadFollows_cmd->bindValue(':Num', $NumQuartY)->queryScalar(); 
			$GeneralData['FollowsOneHalfY']=$GD_ReadFollows_cmd->bindValue(':Num', $NumHalfY)->queryScalar(); 
			/*  */
			/* End General Data */
			
			$GeneralData['GeneralExec']=microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]; 
			
			echo json_encode($GeneralData); 
			exit;
			}
		
		elseif(Yii::$app->request->post('HourlyActivityData')=='Yes'){
			/* Begin Hourly Activity Data */
			/*  */
			$TwentyFourHours['00']='01'; 
			$TwentyFourHours['01']='02'; 
			$TwentyFourHours['02']='03'; 
			$TwentyFourHours['03']='04'; 
			$TwentyFourHours['04']='05'; 
			$TwentyFourHours['05']='06'; 
			$TwentyFourHours['06']='07'; 
			$TwentyFourHours['07']='08'; 
			$TwentyFourHours['08']='09'; 
			$TwentyFourHours['09']='10'; 
			$TwentyFourHours['10']='11'; 
			$TwentyFourHours['11']='12'; 
			$TwentyFourHours['12']='13'; 
			$TwentyFourHours['13']='14'; 
			$TwentyFourHours['14']='15'; 
			$TwentyFourHours['15']='16'; 
			$TwentyFourHours['16']='17'; 
			$TwentyFourHours['17']='18'; 
			$TwentyFourHours['18']='19'; 
			$TwentyFourHours['19']='20'; 
			$TwentyFourHours['20']='21'; 
			$TwentyFourHours['21']='22'; 
			$TwentyFourHours['22']='23'; 
			$TwentyFourHours['23']='00'; 

			// Logins, Posts, Comments, Likes, Follows
				/* Logins */
				$Logins_hourly_cmd=[]; 
				$HourlyData['HourlyBreakdownLogins']=[]; 
				foreach($TwentyFourHours as $eachHour=>$nextHour){
					$TheAS='Logins_'.$eachHour.'_'.$nextHour; 
					$Logins_hourly_cmd[$eachHour]=Yii::$app->db->createCommand("SELECT COUNT(last_login) AS $TheAS FROM user WHERE ((last_login >= (NOW() - INTERVAL 30 DAY)) AND (HOUR(last_login) = '$eachHour')); ")->queryScalar(); 
					//$HourlyData['HourlyBreakdownLogins'].="{x:'$eachHour"."h',y:'$Logins_hourly_cmd[$eachHour]'},";
					array_push($HourlyData['HourlyBreakdownLogins'],['x'=>($eachHour.'h'),'y'=>$Logins_hourly_cmd[$eachHour]]);
					}; 
	
				/* Posts */
				$Posts_hourly_cmd=[]; 
				$HourlyData['HourlyBreakdownPosts']=[]; 
				foreach($TwentyFourHours as $eachHour=>$nextHour){
					$TheAS='Posts_'.$eachHour.'_'.$nextHour; 
					$Posts_hourly_cmd[$eachHour]=Yii::$app->db->createCommand("SELECT COUNT(updated_at) AS $TheAS FROM post WHERE ((updated_at >= (NOW() - INTERVAL 30 DAY)) AND (HOUR(updated_at) = '$eachHour')); ")->queryScalar(); 
					//$HourlyData['HourlyBreakdownPosts'].="{x:'$eachHour"."h',y:'$Posts_hourly_cmd[$eachHour]'},";
					array_push($HourlyData['HourlyBreakdownPosts'],['x'=>($eachHour.'h'),'y'=>$Posts_hourly_cmd[$eachHour]]);
					}; 
	
				/* Comments */
				$Comments_hourly_cmd=[]; 
				$HourlyData['HourlyBreakdownComments']=[]; 
				foreach($TwentyFourHours as $eachHour=>$nextHour){
					$TheAS='Comments_'.$eachHour.'_'.$nextHour; 
					$Comments_hourly_cmd[$eachHour]=Yii::$app->db->createCommand("SELECT COUNT(updated_at) AS $TheAS FROM comment WHERE ((updated_at >= (NOW() - INTERVAL 30 DAY)) AND (HOUR(updated_at) = '$eachHour')); ")->queryScalar(); 
					//$HourlyData['HourlyBreakdownComments'].="{x:'$eachHour"."h',y:'$Comments_hourly_cmd[$eachHour]'},";
					array_push($HourlyData['HourlyBreakdownComments'],['x'=>($eachHour.'h'),'y'=>$Comments_hourly_cmd[$eachHour]]);
					}; 
	
				/* Likes */
				$Likes_hourly_cmd=[]; 
				$HourlyData['HourlyBreakdownLikes']=[]; 
				foreach($TwentyFourHours as $eachHour=>$nextHour){
					$TheAS='Likes_'.$eachHour.'_'.$nextHour; 
					$Likes_hourly_cmd[$eachHour]=Yii::$app->db->createCommand("SELECT COUNT(updated_at) AS $TheAS FROM `like` WHERE ((updated_at >= (NOW() - INTERVAL 30 DAY)) AND (HOUR(updated_at) = '$eachHour')); ")->queryScalar(); 
					//$HourlyData['HourlyBreakdownLikes'].="{x:'$eachHour"."h',y:'$Likes_hourly_cmd[$eachHour]'},";
					array_push($HourlyData['HourlyBreakdownLikes'],['x'=>($eachHour.'h'),'y'=>$Likes_hourly_cmd[$eachHour]]);
					};
	
				/* Follows */
				$Follows_hourly_cmd=[]; 
				$HourlyData['HourlyBreakdownFollows']=[]; 
				foreach($TwentyFourHours as $eachHour=>$nextHour){
					$TheAS='Follows_'.$eachHour.'_'.$nextHour; 
					$Follows_hourly_cmd[$eachHour]=Yii::$app->db->createCommand("SELECT COUNT(created_at) AS $TheAS FROM notification WHERE ((created_at >= (NOW() - INTERVAL 30 DAY) AND source_class=\"humhub\\\\modules\\\\user\\\\models\\\\Follow\") AND (HOUR(created_at) = '$eachHour')); ")->queryScalar(); 
					//$HourlyData['HourlyBreakdownFollows'].="{x:'$eachHour"."h',y:'$Follows_hourly_cmd[$eachHour]'},";
					array_push($HourlyData['HourlyBreakdownFollows'],['x'=>($eachHour.'h'),'y'=>$Follows_hourly_cmd[$eachHour]]);
					}; 
			/* End Hourly Activity Data */
			
			$HourlyData['HourlyExec']=microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]; 
			
			echo json_encode($HourlyData,JSON_FORCE_OBJECT); 
			exit;
			}
		
		else{
			echo 'oops'; 
			exit;
			}
		
		}
	
	
	public function actionHistoricalData(){
		}
	
	
	public function actionGeneralData(){
		}
	
	
	public function actionHourlyActivityData(){
		}
	
	}
