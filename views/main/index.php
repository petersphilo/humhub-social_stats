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


/* use Yii; */
use humhub\modules\admin\permissions\ManageModules;

use yii\helpers\Url;
use yii\helpers\Html;
//use yii\base\Application;
//use yii\db; 
/* use yii\base\Module;  */
use yii\web\AssetBundle;

use humhub\models\Setting;


if (!\Yii::$app->user->can(ManageModules::class)) {
	return; 
	}

$social_stats=Yii::$app->getModule('social_stats'); 
$myDesperationSetting=$social_stats->settings->get('showDesperation'); 
//$myDesperationSetting=1;
$MyBR='<br>'; 

use humhub\modules\social_stats\Assets; 
$MyAssets=humhub\modules\social_stats\Assets::register($this);

?>
		
		<?php
		?>
<div class="panel panel-default">
	<div class="panel-heading"><strong>Social Stats</strong></div>
	<div class="panel-body">
		<style>
			.myjustify {text-align: justify; }
			.mycentertext {text-align: center; }
			.myrighttext {text-align: right !important; }
			.myunderline {text-decoration: underline; }
			.nounderline {text-decoration: none; }
			.mybold {font-weight: bold; }
			.myita {font-style: italic; }
			.mynoita {font-style: normal; }
			.margbotfull {margin-bottom: 1em !important; }
			.margbothalf {margin-bottom: 0.5em !important; }
			.margbotquart {margin-bottom: 0.25em !important; }
			.myjustify {text-align: justify; }
			.mysixteenpix {font-size: 1.2em; line-height: 1.4em; }
			.myfifteenpix {font-size: 1.1em; line-height: 1.3em; }
			.mySmallerText {font-size: 0.8em; line-height: 1em; }
			.mySlightlySmallerText {font-size: 0.9em; line-height: 1.2em; }
			.myfont, .myfont div, .myfont span {font-family: "Open Sans", "Helvetica Neue", Helvetica Neue, "Helvetica", Helvetica, Verdana, sans serif !important; }
			.myturquoiseDark, .myturquoiseDark a, .myturquoiseDark a:visited, a.myturquoiseDark, a.myturquoiseDark:visited {color: #1a8285; } /* 0070C0 orig: 014539 */
			.myturquoiseDark a:hover, a.myturquoiseDark:hover {color: #215868; }
			.SlideyBlock {display: inline-block; margin: 0.5em 1em 0.5em 0em; min-width: 16em; vertical-align: top; }
			.PeriodSelect, .HourlyChartSelect, .dlInactiveUsers, .dlAllUsers, .dlHistDataBU {cursor: pointer; }
			.myFullWidth{width: 100%; margin: 0 auto; min-height: 500px; height: 60%; }
			.MyDataLoading {
				text-shadow: 0px 0px 1px rgba(255,255,255,1), 0px 0px 7px rgba(90,255,90,0.75), 0px 0px 14px rgba(60,255,60,0.6), 0px 0px 22px rgba(90,255,90,0.5); color: rgba(26,130,133,1); 
				animation: GlowyGlowAnim 2s linear infinite; 
				}
			@keyframes GlowyGlowAnim {
				0% {text-shadow: 0px 0px 1px rgba(255,255,255,1), 0px 0px 7px rgba(90,255,90,0.75), 0px 0px 14px rgba(60,255,60,0.6), 0px 0px 22px rgba(90,255,90,0.5); color: rgba(26,130,133,1); }
				50% {text-shadow: 0px 0px 1px rgba(255,255,255,0.1), 0px 0px 5px rgba(90,255,90,0.1), 0px 0px 9px rgba(60,255,60,0.1), 0px 0px 18px rgba(90,255,90,0.1); color: rgba(26,130,133,0.75); }
				100% {text-shadow: 0px 0px 1px rgba(255,255,255,1), 0px 0px 7px rgba(90,255,90,0.75), 0px 0px 14px rgba(60,255,60,0.6), 0px 0px 22px rgba(90,255,90,0.5); color: rgba(26,130,133,1); }
				}
		</style>
		
		<div style='margin: 1em 1em 0 1em; ' id='' class='myjustify myfont'>
	
			<h4>&#x1F4CA; Social Stats! &#x1F9EE; &#x1F5C4; &#x1F5C3;</h4>
			
			<br><br>
			<!-- Logins, Posts, Comments, Likes, Follows -->
	
			<div class='margbothalf'>
				<div class='myjustify margbotYii::t('SocialStatsModule.AllMessages','')half mysixteenpix mybold myunderline'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','General'); ?>:
				</div>
				
				<div class='myjustify '>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Total Active Users (logged in at least once)'); ?>: <span class='myfifteenpix myturquoiseDark HourlyData TotalLogins'><?php echo $GeneralData['TotalLogins']; ?></span>
				</div>
				<div class='myjustify myrighttext margbotquart'>
					<span class='mySmallerText btn-sm btn btn-default dlInactiveUsers'><?php echo Yii::t('SocialStatsModule.AllMessages','download Users never logged in'); ?></span>
				</div>
				<div class='myjustify myrighttext margbotquart'>
					<span class='mySmallerText btn-sm btn btn-default dlAllUsers'>download All Users</span>
				</div>
				<div class='myjustify margbotfull'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Please Note: <br>if the charts don\'t appear, please reload the page, <br>however, loading this page is quite costly to the server; please don\'t reload too often..'); ?>
					<br>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Changing the settings on the Charts doesn\'t affect the server at all, so.. go nuts!'); ?> &#x1F92A;
				</div>
				<br>
			</div>
			<hr>
			<div class='SlideyBlock'>
				<div class='myjustify margbothalf mysixteenpix mybold myunderline'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Unique Logins'); ?>:
				</div>
				<div class='myjustify margbotquart'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Logins in last'); ?> 24h: <span class='myfifteenpix myturquoiseDark GeneralData LoginsOneDay'><?php echo $GeneralData['LoginsOneDay']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Logins in last'); ?> 7 <?php echo Yii::t('SocialStatsModule.AllMessages','days'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData LoginsOneWeek'><?php echo $GeneralData['LoginsOneWeek']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Logins in last'); ?> 30 <?php echo Yii::t('SocialStatsModule.AllMessages','days'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData LoginsOneMonth'><?php echo $GeneralData['LoginsOneMonth']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Logins in last'); ?> 3 <?php echo Yii::t('SocialStatsModule.AllMessages','months'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData LoginsOneQuarterY'><?php echo $GeneralData['LoginsOneQuarterY']; ?></span>
				</div>
				<div class='myjustify margbothalf'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Logins in last'); ?> 6 <?php echo Yii::t('SocialStatsModule.AllMessages','months'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData LoginsOneHalfY'><?php echo $GeneralData['LoginsOneHalfY']; ?></span>
				</div>
				<br>
			</div>
			
			<div class='SlideyBlock'>
				<div class='myjustify margbothalf mysixteenpix mybold myunderline'>
					Posts:
				</div>
				<div class='myjustify margbotquart'>
					Posts <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 24h: <span class='myfifteenpix myturquoiseDark GeneralData PostsOneDay'><?php echo $GeneralData['PostsOneDay']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					Posts <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 7 <?php echo Yii::t('SocialStatsModule.AllMessages','days'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData PostsOneWeek'><?php echo $GeneralData['PostsOneWeek']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					Posts <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 30 <?php echo Yii::t('SocialStatsModule.AllMessages','days'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData PostsOneMonth'><?php echo $GeneralData['PostsOneMonth']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					Posts <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 3 <?php echo Yii::t('SocialStatsModule.AllMessages','months'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData PostsOneQuarterY'><?php echo $GeneralData['PostsOneQuarterY']; ?></span>
				</div>
				<div class='myjustify margbothalf'>
					Posts <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 6 <?php echo Yii::t('SocialStatsModule.AllMessages','months'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData PostsOneHalfY'><?php echo $GeneralData['PostsOneHalfY']; ?></span>
				</div>
				<br>
			</div>
			
			<div class='SlideyBlock'>
				<div class='myjustify margbothalf mysixteenpix mybold myunderline'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Comments'); ?>:
				</div>
				<div class='myjustify margbotquart'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Comments in last'); ?> 24h: <span class='myfifteenpix myturquoiseDark GeneralData CommentsOneDay'><?php echo $GeneralData['CommentsOneDay']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Comments in last'); ?> 7 <?php echo Yii::t('SocialStatsModule.AllMessages','days'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData CommentsOneWeek'><?php echo $GeneralData['CommentsOneWeek']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Comments in last'); ?> 30 <?php echo Yii::t('SocialStatsModule.AllMessages','days'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData CommentsOneMonth'><?php echo $GeneralData['CommentsOneMonth']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Comments in last'); ?> 3 <?php echo Yii::t('SocialStatsModule.AllMessages','months'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData CommentsOneQuarterY'><?php echo $GeneralData['CommentsOneQuarterY']; ?></span>
				</div>
				<div class='myjustify margbothalf'>
					<?php echo Yii::t('SocialStatsModule.AllMessages','Comments in last'); ?> 6 <?php echo Yii::t('SocialStatsModule.AllMessages','months'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData CommentsOneHalfY'><?php echo $GeneralData['CommentsOneHalfY']; ?></span>
				</div>
				<br>
			</div>
			
			<div class='SlideyBlock'>
				<div class='myjustify margbothalf mysixteenpix mybold myunderline'>
					Likes:
				</div>
				<div class='myjustify margbotquart'>
					Likes <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 24h: <span class='myfifteenpix myturquoiseDark GeneralData LikesOneDay'><?php echo $GeneralData['LikesOneDay']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					Likes <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 7 <?php echo Yii::t('SocialStatsModule.AllMessages','days'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData LikesOneWeek'><?php echo $GeneralData['LikesOneWeek']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					Likes <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 30 <?php echo Yii::t('SocialStatsModule.AllMessages','days'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData LikesOneMonth'><?php echo $GeneralData['LikesOneMonth']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					Likes <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 3 <?php echo Yii::t('SocialStatsModule.AllMessages','months'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData LikesOneQuarterY'><?php echo $GeneralData['LikesOneQuarterY']; ?></span>
				</div>
				<div class='myjustify margbothalf'>
					Likes <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 6 <?php echo Yii::t('SocialStatsModule.AllMessages','months'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData LikesOneHalfY'><?php echo $GeneralData['LikesOneHalfY']; ?></span>
				</div>
				<br>
			</div>
			
			<div class='SlideyBlock'>
				<div class='myjustify margbothalf mysixteenpix mybold myunderline'>
					Follows:
				</div>
				<div class='myjustify margbotquart'>
					Follows <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 24h: <span class='myfifteenpix myturquoiseDark GeneralData FollowsOneDay'><?php echo $GeneralData['FollowsOneDay']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					Follows <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 7 <?php echo Yii::t('SocialStatsModule.AllMessages','days'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData FollowsOneWeek'><?php echo $GeneralData['FollowsOneWeek']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					Follows <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 30 <?php echo Yii::t('SocialStatsModule.AllMessages','days'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData FollowsOneMonth'><?php echo $GeneralData['FollowsOneMonth']; ?></span>
				</div>
				<div class='myjustify margbotquart'>
					Follows <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 3 <?php echo Yii::t('SocialStatsModule.AllMessages','months'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData FollowsOneQuarterY'><?php echo $GeneralData['FollowsOneQuarterY']; ?></span>
				</div>
				<div class='myjustify margbothalf'>
					Follows <?php echo Yii::t('SocialStatsModule.AllMessages','in last'); ?> 6 <?php echo Yii::t('SocialStatsModule.AllMessages','months'); ?>: <span class='myfifteenpix myturquoiseDark GeneralData FollowsOneHalfY'><?php echo $GeneralData['FollowsOneHalfY']; ?></span>
				</div>
				<br>
			</div>
		</div>
		<div class='mySmallerText margbotfull'><?php echo Yii::t('SocialStatsModule.AllMessages','General Data Process Time'); ?>: <span class='GeneralExec'><?php echo $GeneralData['GeneralExec']; ?></span></div>
		<div class='mySlightlySmallerText myjustify'>
			<span class='myita'><?php echo Yii::t('SocialStatsModule.AllMessages','Explanation of Logins data'); ?>:</span><br>
			<?php echo Yii::t('SocialStatsModule.AllMessages','Please note that HumHub does not record historical data regarding Logins'); ?>..<br>
			<?php echo Yii::t('SocialStatsModule.AllMessages','This means that we are only ever seeing'); ?> '<span class='myita'><?php echo Yii::t('SocialStatsModule.AllMessages','Individual People\'s Logins'); ?></span>' (<?php echo Yii::t('SocialStatsModule.AllMessages','Unique Logins'); ?>);<br>
			<?php echo Yii::t('SocialStatsModule.AllMessages','so, the numbers above show how many people logged in – or renewed their session – at least once in the given time'); ?>..<br>
			<?php echo Yii::t('SocialStatsModule.AllMessages','This is why the Historical chart just below is interesting'); ?>,<br>
			<?php echo Yii::t('SocialStatsModule.AllMessages','because it records the number of Unique Logins every 24 hours, and displays them once per day'); ?>..<br>
			<?php echo Yii::t('SocialStatsModule.AllMessages','The rest of the data behaves more as you\'d expect'); ?>..
		</div>
		<br>
		
		<hr>
		
		<br><br>
		
		
		<div class='mycentertext margbotfull mysixteenpix mybold myunderline'>
			<?php echo Yii::t('SocialStatsModule.AllMessages','Historical data'); ?> - <span class='mySmallerText'>(<?php echo Yii::t('SocialStatsModule.AllMessages','click data titles to disable/enable'); ?>)</span>
		</div>
		
	
		<div class='myrighttext margbotquart'>
			<span class='PeriodSelect SelectOneWeek'><?php echo Yii::t('SocialStatsModule.AllMessages','Last Week'); ?></span> - <span class='PeriodSelect SelectOneMonth'><?php echo Yii::t('SocialStatsModule.AllMessages','Last Month'); ?></span> - <span class='PeriodSelect SelectOneSixMo mybold'><?php echo Yii::t('SocialStatsModule.AllMessages','Last 6 Months'); ?></span> - <span class='PeriodSelect SelectOneYear'><?php echo Yii::t('SocialStatsModule.AllMessages','Last Year'); ?></span> - <span class='PeriodSelect SelectOneAll'><?php echo Yii::t('SocialStatsModule.AllMessages','All'); ?></span>
		</div>
		
		<canvas class='myFullWidth margbothalf' id='MyDailyChart'></canvas>
		
		<div class='mycentertext margbotquart mySlightlySmallerText'>
			<?php echo Yii::t('SocialStatsModule.AllMessages','These are <i>total</i> numbers per day'); ?>..<br>
			<span class='mySmallerText'><?php echo Yii::t('SocialStatsModule.AllMessages','Please note that the data from this chart will build at the rate of once per day'); ?>..<br>
			<?php echo Yii::t('SocialStatsModule.AllMessages','So you will only see data points appear once per day'); ?>..</span>
		</div>
				<div class='myjustify myrighttext margbothalf'>
					<span class='mySmallerText btn-sm btn btn-default dlHistDataBU dlHistDataCSV'><?php echo Yii::t('SocialStatsModule.AllMessages','download CSV backup of this data'); ?></span><br>
					<span class='mySmallerText btn-sm btn btn-default dlHistDataBU dlHistDataSQL'><?php echo Yii::t('SocialStatsModule.AllMessages','download SQL backup of this data'); ?></span>
				</div>
		
		<span class='mySmallerText'><?php echo Yii::t('SocialStatsModule.AllMessages','Historical Chart Process Time'); ?>: <span class='DailyExec'><?php echo $DailyData['DailyExec']; ?></span></span>
		
		<br><br>
		
		<hr>
		
		<br><br>
		
		<div class='mycentertext margbotfull mysixteenpix mybold myunderline'>
			<?php echo Yii::t('SocialStatsModule.AllMessages','Hourly Activity'); ?> - <span class='mySmallerText'>(<?php echo Yii::t('SocialStatsModule.AllMessages','click data titles to disable/enable'); ?>)</span>
		</div>
		
		
		<?php
			$ThisTimeZone=\Yii::$app->getTimeZone(); 
			/* echo $MyBR.$ThisTimeZone."; date('T'): ".date('T')."; date('P'): ".date('P')."; date('P') short: ".substr(date('P'),0,3)."; just city: ".substr($ThisTimeZone,(strpos($ThisTimeZone,'/')+1));  */
		?>
		
		<div class='myrighttext margbotquart'>
			<?php echo Yii::t('SocialStatsModule.AllMessages','Change TimeZone'); ?> <span class='mySmallerText'>(<?php echo Yii::t('SocialStatsModule.AllMessages','server time is'); ?> <?php echo substr($ThisTimeZone,(strpos($ThisTimeZone,'/')+1)).' - UTC'.substr(date('P'),0,3); ?>)</span>: &emsp; 
			<span class='HourlyChartSelect SelectServerMinusThree'>-3h</span>
			 &emsp;–&emsp; 
			<span class='HourlyChartSelect SelectServerMinusTwo'>-2h</span>
			 &emsp;–&emsp; 
			<span class='HourlyChartSelect SelectServerMinusOne'>-1h</span>
			 &emsp;–&emsp; 
			<span class='HourlyChartSelect SelectServerTime mybold'><?php echo Yii::t('SocialStatsModule.AllMessages','Server Time'); ?></span>
			 &emsp;–&emsp; 
			<span class='HourlyChartSelect SelectServerPlusOne'>+1h</span>
			 &emsp;–&emsp; 
			<span class='HourlyChartSelect SelectServerPlusTwo'>+2h</span>
			 &emsp;–&emsp; 
			<span class='HourlyChartSelect SelectServerPlusThree'>+3h</span>
		</div>
		
		<canvas class='myFullWidth margbothalf' id='MyHourlyBreakdownChart'><?php echo Yii::t('SocialStatsModule.AllMessages','Loading'); ?>..</canvas>
		
		<div class='mycentertext margbotfull mySlightlySmallerText'>
			<?php echo Yii::t('SocialStatsModule.AllMessages','These are <i>total</i> numbers from the last 30 days at each hour; you would divide these numbers by 30 to get an average'); ?>..
		</div>
		
		<span class='mySmallerText'><?php echo Yii::t('SocialStatsModule.AllMessages','Hourly Activity Process Time'); ?>: <span class='HourlyExec'><?php echo $HourlyData['HourlyExec']; ?></span></span>
		
		<br>
		
		<span class='testarea'></span>
		<br>
		
		<script <?php echo humhub\libs\Html::nonce(); ?>>
			/* -- Begin main inline JS */
			$(function(){
				var MyDailyChartSelector=$('#MyDailyChart'),
					MyHourlyBreakdownChartSelector=$('#MyHourlyBreakdownChart'),
					
					DailyLoginsFull=[],
					DailyPostsFull=[],
					DailyCommentsFull=[],
					DailyLikesFull=[],
					DailyFollowsFull=[],
					/*
					DailyLoginsSixMo=DailyLoginsFull.slice(-182),
					DailyPostsSixMo=DailyPostsFull.slice(-182),
					DailyCommentsSixMo=DailyCommentsFull.slice(-182),
					DailyLikesSixMo=DailyLikesFull.slice(-182),
					DailyFollowsSixMo=DailyFollowsFull.slice(-182),
					*/
					HourlyBreakdownLogins=[], 
					HourlyBreakdownPosts=[], 
					HourlyBreakdownComments=[], 
					HourlyBreakdownLikes=[], 
					HourlyBreakdownFollows=[], 
					
					
					MyDailyChart,
					MyHourlyBreakdownChart,
					
					MyTestText='', 
					MyBR='<br>', 
					GDSelector='',
					
					MyCurrentGetURL="/social_stats/main",
					MyNewGetURL,
					MyFetchURL;
				
				
				/* -- Begin Daily Chart -- */
				DailyLoginsFull.length = 0;
				DailyPostsFull.length = 0;
				DailyCommentsFull.length = 0;
				DailyLikesFull.length = 0;
				DailyFollowsFull.length = 0;
				
				var DailyData=<?php echo json_encode($DailyData,JSON_FORCE_OBJECT); ?>
				
				$.each(DailyData.DailyLogins,function(key,val){
					DailyLoginsFull.push(val);
					});
				$.each(DailyData.DailyPosts,function(key,val){
					DailyPostsFull.push(val);
					});
				$.each(DailyData.DailyComments,function(key,val){
					DailyCommentsFull.push(val);
					});
				$.each(DailyData.DailyLikes,function(key,val){
					DailyLikesFull.push(val);
					});
				$.each(DailyData.DailyFollows,function(key,val){
					DailyFollowsFull.push(val);
					});
					
				var
					DailyLoginsSixMo=DailyLoginsFull.slice(-182),
					DailyPostsSixMo=DailyPostsFull.slice(-182),
					DailyCommentsSixMo=DailyCommentsFull.slice(-182),
					DailyLikesSixMo=DailyLikesFull.slice(-182),
					DailyFollowsSixMo=DailyFollowsFull.slice(-182);
				
				
				MyDailyChart=new Chart(MyDailyChartSelector, {
					type: 'line',
					data: {
						datasets: [
							{
								label: 'Daily Logins',
								borderColor: 'rgba(75,192,192,0.98)', /* #4bc0c0 */
								backgroundColor: 'rgba(75,192,192,0.98)',
								data:DailyLoginsSixMo,
								indexAxis:'x',
								},
							{
								label: 'Daily Posts',
								borderColor: 'rgba(66,151,253,0.98)', /* #4297fd */
								backgroundColor: 'rgba(66,151,253,0.98)',
								data:DailyPostsSixMo,
								indexAxis:'x',
								/* hidden:true, */
								},
							{
								label: 'Daily Comments',
								borderColor: 'rgba(184,127,253,0.98)', /* #b87ffd */
								backgroundColor: 'rgba(184,127,253,0.98)',
								data:DailyCommentsSixMo,
								indexAxis:'x',
								/* hidden:true, */
								},
							{
								label: 'Daily Likes',
								borderColor: 'rgba(0,224,127,0.98)', /* #00e07f */
								backgroundColor: 'rgba(0,224,127,0.98)',
								data:DailyLikesSixMo,
								indexAxis:'x',
								/* hidden:true, */
								},
							{
								label: 'Daily Follows',
								borderColor: 'rgba(198,106,140,0.98)', /* #c66a8c */
								backgroundColor: 'rgba(198,106,140,0.98)',
								data:DailyFollowsSixMo,
								indexAxis:'x',
								/* hidden:true, */
								},
							],
						},
					options: {
						scales: {
							xAxis: {
								/* type: 'time', */
								ticks: {
									autoSkip: true,
									maxTicksLimit: 12,
									}
								},
							},
						aspectRatio: 1.5,
						},
					borderColor: 'rgb(75, 192, 192)',
					tension: 0.8,
					});
				
					$('.PeriodSelect').on('click',function(){
						$('.PeriodSelect').removeClass('mybold'); 
						$(this).addClass('mybold'); 
						/* Logins, Posts, Comments, Likes, Follows */
						if($(this).hasClass('SelectOneWeek')){UpdateChartData(
							DailyLoginsFull.slice(-7),
							DailyPostsFull.slice(-7),
							DailyCommentsFull.slice(-7),
							DailyLikesFull.slice(-7),
							DailyFollowsFull.slice(-7),
							7)}
						else if($(this).hasClass('SelectOneMonth')){UpdateChartData(
							DailyLoginsFull.slice(-30),
							DailyPostsFull.slice(-30),
							DailyCommentsFull.slice(-30),
							DailyLikesFull.slice(-30),
							DailyFollowsFull.slice(-30),
							15)}
						else if($(this).hasClass('SelectOneSixMo')){UpdateChartData(
							DailyLoginsFull.slice(-182),
							DailyPostsFull.slice(-182),
							DailyCommentsFull.slice(-182),
							DailyLikesFull.slice(-182),
							DailyFollowsFull.slice(-182),
							12)}
						else if($(this).hasClass('SelectOneYear')){UpdateChartData(
							DailyLoginsFull.slice(-365),
							DailyPostsFull.slice(-365),
							DailyCommentsFull.slice(-365),
							DailyLikesFull.slice(-365),
							DailyFollowsFull.slice(-365),
							12)}
						else if($(this).hasClass('SelectOneAll')){UpdateChartData(
							DailyLoginsFull,
							DailyPostsFull,
							DailyCommentsFull,
							DailyLikesFull,
							DailyFollowsFull,
							12)}
						
						}); 
					
					UpdateChartData=function(DataZero,DataOne,DataTwo,DataThree,DataFour,Ticks){
						MyDailyChart.data.datasets[0].data=DataZero; 
						MyDailyChart.data.datasets[1].data=DataOne; 
						MyDailyChart.data.datasets[2].data=DataTwo; 
						MyDailyChart.data.datasets[3].data=DataThree; 
						MyDailyChart.data.datasets[4].data=DataFour; 
						MyDailyChart.options.scales.xAxis.ticks.maxTicksLimit=Ticks;
						MyDailyChart.update(); 
						}; 
				/* -- End Daily Chart -- */
				
				/* -- Begin Hourly Chart -- */
				HourlyBreakdownLogins.length = 0;
				HourlyBreakdownPosts.length = 0;
				HourlyBreakdownComments.length = 0;
				HourlyBreakdownLikes.length = 0;
				HourlyBreakdownFollows.length = 0;
				
				var HourlyData=<?php echo json_encode($HourlyData,JSON_FORCE_OBJECT); ?>
				
				$.each(HourlyData.HourlyBreakdownLogins,function(key,val){
					HourlyBreakdownLogins.push(val);
					});
				$.each(HourlyData.HourlyBreakdownPosts,function(key,val){
					HourlyBreakdownPosts.push(val);
					});
				$.each(HourlyData.HourlyBreakdownComments,function(key,val){
					HourlyBreakdownComments.push(val);
					});
				$.each(HourlyData.HourlyBreakdownLikes,function(key,val){
					HourlyBreakdownLikes.push(val);
					});
				$.each(HourlyData.HourlyBreakdownFollows,function(key,val){
					HourlyBreakdownFollows.push(val);
					});
				
				MyHourlyBreakdownChart=new Chart(MyHourlyBreakdownChartSelector, {
					type: 'line',
					data: {
						datasets: [
							{
								label: 'Hourly Logins',
								borderColor: 'rgba(75,192,192,0.98)',
								backgroundColor: 'rgba(75,192,192,0.25)',
								fill:'start',
								data:HourlyBreakdownLogins,
								indexAxis:'x',
								tension: 0.2,
								},
							{
								label: 'Hourly Posts',
								borderColor: 'rgba(66,151,253,0.98)',
								backgroundColor: 'rgba(66,151,253,0.25)',
								fill:'start',
								data:HourlyBreakdownPosts,
								indexAxis:'x',
								tension: 0.2,
								},
							{
								label: 'Hourly Comments',
								borderColor: 'rgba(184,127,253,0.98)',
								backgroundColor: 'rgba(184,127,253,0.25)',
								fill:'start',
								data:HourlyBreakdownComments,
								indexAxis:'x',
								tension: 0.2,
								},
							{
								label: 'Hourly Likes',
								borderColor: 'rgba(0,224,127,0.98)',
								backgroundColor: 'rgba(0,224,127,0.25)',
								fill:'start',
								data:HourlyBreakdownLikes,
								indexAxis:'x',
								tension: 0.2,
								},
							{
								label: 'Hourly Follows',
								borderColor: 'rgba(198,106,140,0.98)',
								backgroundColor: 'rgba(198,106,140,0.25)',
								fill:'start',
								data:HourlyBreakdownFollows,
								indexAxis:'x',
								tension: 0.2,
								},
							],
						},
					options: {
						scales: {
							xAxis: {
								ticks: {
									autoSkip: false,
									maxTicksLimit: 12,
									}, 
								title: {
									display: true,
									text: 'Hour of Day (Data from the Last 30 Days)',
									}
								},
							yAxis: {
								ticks: {
									callback:  function(val,i,ticks){
											return val.toString().replace(/000000/,'M').replace(/500000/,'.5M').replace(/000/,'k').replace(/(\d+)500/,'$1.5k');
											}
									}, 
								},
							},
						aspectRatio: 1.5,
						},
					borderColor: 'rgb(75, 192, 192)',
					}); 
				
				$('.HourlyChartSelect').on('click',function(){
					$('.HourlyChartSelect').removeClass('mybold'); 
					$(this).addClass('mybold'); 
					/* Logins, Posts, Comments, Likes, Follows */
					if($(this).hasClass('SelectServerPlusOne')){
						UpdateHourlyChartData('+1'); 
						}
					else if($(this).hasClass('SelectServerPlusTwo')){
						UpdateHourlyChartData('+2'); 
						}
					else if($(this).hasClass('SelectServerPlusThree')){
						UpdateHourlyChartData('+3'); 
						}
					else if($(this).hasClass('SelectServerTime')){ /* default */
						UpdateHourlyChartData(0); 
						}
					else if($(this).hasClass('SelectServerMinusOne')){
						UpdateHourlyChartData('-1'); 
						}
					else if($(this).hasClass('SelectServerMinusTwo')){
						UpdateHourlyChartData('-2'); 
						}
					else if($(this).hasClass('SelectServerMinusThree')){
						UpdateHourlyChartData('-3'); 
						}
					
					}); 
				
				
				ShiftHourlyChartDataPlusTwo=function(data){
					data.forEach(function(datum,i){
						if(i==22){
							data.splice(i,1);
							data.unshift(datum);
							datum.x='00h';
							}
						else if(i==23){
							data.splice(i,1);
							data.splice(1,0,datum);
							datum.x='01h';
							}
						else{
							datum.x=String(i+2).padStart(2,'0')+'h'; 
							}
						});
					}
				
				ShiftHourlyChartDataPlusThree=function(data){
					data.forEach(function(datum,i){
						if(i==21){
							data.splice(i,1);
							data.unshift(datum);
							datum.x='00h';
							}
						else if(i==22){
							data.splice(i,1);
							data.splice(1,0,datum);
							datum.x='01h';
							}
						else if(i==23){
							data.splice(i,1);
							data.splice(2,0,datum);
							datum.x='02h';
							}
						else{
							datum.x=String(i+3).padStart(2,'0')+'h'; 
							}
						});
					}
						
				
				ShiftHourlyChartDataPlusOne=function(data){
					data.forEach(function(datum,i){
						if(i==23){
							data.splice(i,1);
							data.unshift(datum);
							datum.x='00h';
							}
						else{
							datum.x=String(i+1).padStart(2,'0')+'h'; 
							}
						});
					}
				
				ShiftHourlyChartDataMinusOne=function(data){
					data.forEach(function(datum,i){
						if(i==0){
							datum.x='23h';
							data.push(data.shift()); 
							data[0].x='00h'; 
							}
						else if(i<23){
							datum.x=String(i).padStart(2,'0')+'h'; 
							}
						});
					}
				
				ShiftHourlyChartDataMinusTwo=function(data){
					data.forEach(function(datum,i){
						if(i==0){
							datum.x='22h';
							data.push(data.shift()); 
							data.push(data.shift()); 
							data[0].x='00h'; 
							data[23].x='23h'; 
							}
						else if(i<22){
							datum.x=String(i).padStart(2,'0')+'h'; 
							}
						});	
					}
				
				ShiftHourlyChartDataMinusThree=function(data){
					data.forEach(function(datum,i){
						if(i==0){
							datum.x='21h';
							data.push(data.shift()); 
							data.push(data.shift()); 
							data.push(data.shift()); 
							data[0].x='00h'; 
							data[22].x='22h'; 
							data[23].x='23h'; 
							}
						else if(i<21){
							datum.x=String(i).padStart(2,'0')+'h'; 
							}
						});	
					}
				
				
				UpdateHourlyChartData=function(NumOfHoursShift){
					
					var HBLogins=HourlyBreakdownLogins.slice(),
					HBPosts=HourlyBreakdownPosts.slice(),
					HBComments=HourlyBreakdownComments.slice(),
					HBLikes=HourlyBreakdownLikes.slice(),
					HBFollows=HourlyBreakdownFollows.slice(); 
					
					var MyFullDataSet=[HBLogins,HBPosts,HBComments,HBLikes,HBFollows]; 
					
					if(NumOfHoursShift=='+3'){
						MyFullDataSet.forEach(function(EachDataSet){
							ShiftHourlyChartDataPlusThree(EachDataSet); 
							})
						}
					if(NumOfHoursShift=='+2'){
						MyFullDataSet.forEach(function(EachDataSet){
							ShiftHourlyChartDataPlusTwo(EachDataSet); 
							})
						}
					if(NumOfHoursShift=='+1'){
						MyFullDataSet.forEach(function(EachDataSet){
							ShiftHourlyChartDataPlusOne(EachDataSet); 
							})
						}
					if(NumOfHoursShift=='-1'){
						MyFullDataSet.forEach(function(EachDataSet){
							ShiftHourlyChartDataMinusOne(EachDataSet); 
							})
						}
					if(NumOfHoursShift=='-2'){
						MyFullDataSet.forEach(function(EachDataSet){
							ShiftHourlyChartDataMinusTwo(EachDataSet); 
							})
						}
					if(NumOfHoursShift=='-3'){
						MyFullDataSet.forEach(function(EachDataSet){
							ShiftHourlyChartDataMinusThree(EachDataSet); 
							})
						}
			
					MyFullDataSet.forEach(function(EachDataSet,i){
							MyHourlyBreakdownChart.data.datasets[i].data=EachDataSet; 
							})
					
					MyHourlyBreakdownChart.update(); 
					}; 
				/* -- End Hourly Chart -- */
				
				/* -- Begin dl data -- */
				$('.dlInactiveUsers').on('click',function(){
					//MyCurrentGetURL=window.location.search; 
					if(MyCurrentGetURL.length){MyNewGetURL=MyCurrentGetURL+'?dlInactiveAccnts=Yes'; }
					else{MyNewGetURL='./?dlInactiveAccnts=Yes'; }
					/* console.log('MyCurrentGetURL.length: '+MyCurrentGetURL.length+'; MyCurrentGetURL: '+MyCurrentGetURL+'; MyNewGetURL: '+MyNewGetURL);  */
					fetch(MyNewGetURL)
						.then(resp => resp.blob())
						.then(blob => {
							var Myurl = window.URL.createObjectURL(blob);
							const TempdlLink = document.createElement('a');
							TempdlLink.style.display = 'none';
							TempdlLink.href = Myurl;
							TempdlLink.download = 'InactiveAccnts.csv';
							document.body.appendChild(TempdlLink);
							TempdlLink.click();
							window.URL.revokeObjectURL(Myurl);
							TempdlLink.remove();
							})
						.catch(() => alert('the problem is here..'));
					}); 
				
				
				$('.dlAllUsers').on('click',function(){
					//MyCurrentGetURL=window.location.search; 
					if(MyCurrentGetURL.length){MyNewGetURL=MyCurrentGetURL+'?dlAllAccnts=Yes'; }
					else{MyNewGetURL='./?dlAllAccnts=Yes'; }
					// console.log('MyCurrentGetURL.length: '+MyCurrentGetURL.length+'; MyCurrentGetURL: '+MyCurrentGetURL+'; MyNewGetURL: '+MyNewGetURL); 
					fetch(MyNewGetURL)
						.then(resp => resp.blob())
						.then(blob => {
							var Myurl = window.URL.createObjectURL(blob);
							const TempdlLink = document.createElement('a');
							TempdlLink.style.display = 'none';
							TempdlLink.href = Myurl;
							TempdlLink.download = 'AllAccnts.csv';
							document.body.appendChild(TempdlLink);
							TempdlLink.click();
							window.URL.revokeObjectURL(Myurl);
							TempdlLink.remove();
							})
						.catch(() => alert('the problem is here..'));
					}); 
				
				
				$('.dlHistDataBU').on('click',function(){
					//MyCurrentGetURL=window.location.search; 
					var dlType='sql';
					if($(this).hasClass('dlHistDataCSV')){dlType='csv'; } 
					if(MyCurrentGetURL.length){MyNewGetURL=MyCurrentGetURL+'?dlHistDataBU='+dlType; }
					else{MyNewGetURL='./?dlHistDataBU='+dlType; }
					fetch(MyNewGetURL)
						.then(resp => resp.blob())
						.then(blob => {
							var Myurl = window.URL.createObjectURL(blob);
							const TempdlLink = document.createElement('a');
							TempdlLink.style.display = 'none';
							TempdlLink.href = Myurl;
							TempdlLink.download = 'HistoricalChartData.'+dlType+'.gz';
							document.body.appendChild(TempdlLink);
							TempdlLink.click();
							window.URL.revokeObjectURL(Myurl);
							TempdlLink.remove();
							})
						.catch(() => alert('something went wrong..'));
					}); 
				/* -- End dl data -- */
				
				
				
				
				
				}); 
			/* -- End main inline JS */
		</script>
		
		<!-- Begin desperation -->
		<?php if($myDesperationSetting==0){ ?>
			<div class='mycentertext margbothalf mySlightlySmallerText'>
				to donate, <a class='myClickToDonate myturquoiseDark' href="<?php echo Url::to(['/social_stats/main/index?myClickToDonate=myShowDonation']); ?>">click here</a>
			</div>
		
		<?php }else{ ?>
			<div class='mycentertext margbothalf mySlightlySmallerText'>
				if you find this module useful, please consider a donation<br>
				it'd really, really, really, really, <br>
				really, really, really help..
			</div>
			<div id="donate-button-container" class='mycentertext margbothalf'>
				<div id="donate-button"></div>
				<script <?php echo humhub\libs\Html::nonce(); ?> src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
				<script <?php echo humhub\libs\Html::nonce(); ?>>
					PayPal.Donation.Button({
						env:'production',
						hosted_button_id:'AEA7Q4V5RMY4S',
						image: {
							src:'https://www.paypalobjects.com/en_US/FR/i/btn/btn_donateCC_LG.gif',
							alt:'Donate with PayPal button',
							title:'Please consider making a donation; it would help me greatly..',
							}
						}).render('#donate-button');
				</script>
			</div>
			<div class='mycentertext margbothalf mySlightlySmallerText'>
				to hide this, <a class='myClickToHideDonation myturquoiseDark' href="<?php echo Url::to(['/social_stats/main/index?myClickToDonate=myHideDonation']); ?>">click here</a>
			</div>
		<?php };  ?>
		<!-- i wish i could say that's the end of it.. -->
	</div>
</div>

