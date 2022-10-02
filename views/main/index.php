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
use humhub\libs\Html;
use yii\base\Application;
use yii\db\Connection; 
/* use yii\base\Module;  */
use yii\web\AssetBundle;

$_SESSION['social_stats_sesh']='MySocialStatsSesh'; 

use humhub\modules\social_stats; 

if (!\Yii::$app->user->can(ManageModules::class)) {
	return; 
	}

$MyBR='<br>'; 

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
			.PeriodSelect, .HourlyChartSelect, .dlInactiveUsers, .dlHistDataBU {cursor: pointer; }
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
				<div class='myjustify margbothalf mysixteenpix mybold myunderline'>
					<?= Yii::t('SocialStatsModule.base', 'General:'); ?>
				</div>
				<div class='mycentertext margbotfull myita myturquoiseDark GeneralDataReady MyDataLoading'><?= Yii::t('SocialStatsModule.base', 'Please wait for data to load..'); ?></div>
				<div class='myjustify '>
					<?= Yii::t('SocialStatsModule.base', 'Total Active Users (logged in at least once):'); ?> <span class='myfifteenpix myturquoiseDark HourlyData TotalLogins'>...</span>
				</div>
				<div class='myjustify myrighttext margbotquart'>
					<span class='mySmallerText myturquoiseDark dlInactiveUsers'><?= Yii::t('SocialStatsModule.base', 'download Users never logged in'); ?></span>
				</div>
				<div class='myjustify margbotfull'>
					<?= Yii::t('SocialStatsModule.base', 'Please Note: Loading this page is quite costly to the server; please don\'t reload too often..'); ?>
					<br>
					<?= Yii::t('SocialStatsModule.base', 'Changing the settings on the Charts doesn\'t affect the server at all, so.. go nuts! &#x1F92A;'); ?>
				</div>
				<br>
			</div>
			<hr>
			<div class='SlideyBlock'>
				<div class='myjustify margbothalf mysixteenpix mybold myunderline'>
					<?= Yii::t('SocialStatsModule.base', 'Unique Logins:'); ?>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Logins in last 24h:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData LoginsOneDay'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Logins in last 7 days:') ?> <span class='myfifteenpix myturquoiseDark GeneralData LoginsOneWeek'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Logins in last 30 days:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData LoginsOneMonth'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Logins in last 3 months:') ?> <span class='myfifteenpix myturquoiseDark GeneralData LoginsOneQuarterY'>...</span>
				</div>
				<div class='myjustify margbothalf'>
					<?= Yii::t('SocialStatsModule.base', 'Logins in last 6 months:') ?> <span class='myfifteenpix myturquoiseDark GeneralData LoginsOneHalfY'>...</span>
				</div>
				<br>
			</div>
			
			<div class='SlideyBlock'>
				<div class='myjustify margbothalf mysixteenpix mybold myunderline'>
					<?= Yii::t('SocialStatsModule.base', 'Posts:'); ?>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Posts in last 24h:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData PostsOneDay'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Posts in last 7 days:') ?> <span class='myfifteenpix myturquoiseDark GeneralData PostsOneWeek'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Posts in last 30 days:') ?> <span class='myfifteenpix myturquoiseDark GeneralData PostsOneMonth'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Posts in last 3 months:') ?> <span class='myfifteenpix myturquoiseDark GeneralData PostsOneQuarterY'>...</span>
				</div>
				<div class='myjustify margbothalf'>
					<?= Yii::t('SocialStatsModule.base', 'Posts in last 6 months:') ?> <span class='myfifteenpix myturquoiseDark GeneralData PostsOneHalfY'>...</span>
				</div>
				<br>
			</div>
			
			<div class='SlideyBlock'>
				<div class='myjustify margbothalf mysixteenpix mybold myunderline'>
					<?= Yii::t('SocialStatsModule.base', 'Comments:'); ?>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Comments in last 24h:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData CommentsOneDay'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Comments in last 7 days:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData CommentsOneWeek'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Comments in last 30 days:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData CommentsOneMonth'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Comments in last 3 months:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData CommentsOneQuarterY'>...</span>
				</div>
				<div class='myjustify margbothalf'>
					<?= Yii::t('SocialStatsModule.base', 'Comments in last 6 months:') ?> <span class='myfifteenpix myturquoiseDark GeneralData CommentsOneHalfY'>...</span>
				</div>
				<br>
			</div>
			
			<div class='SlideyBlock'>
				<div class='myjustify margbothalf mysixteenpix mybold myunderline'>
					<?= Yii::t('SocialStatsModule.base', 'Likes:'); ?>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Likes in last 24h:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData LikesOneDay'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Likes in last 7 days:') ?> <span class='myfifteenpix myturquoiseDark GeneralData LikesOneWeek'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Likes in last 30 days:') ?> <span class='myfifteenpix myturquoiseDark GeneralData LikesOneMonth'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Likes in last 3 months:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData LikesOneQuarterY'>...</span>
				</div>
				<div class='myjustify margbothalf'>
					<?= Yii::t('SocialStatsModule.base', 'Likes in last 6 months:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData LikesOneHalfY'>...</span>
				</div>
				<br>
			</div>
			
			<div class='SlideyBlock'>
				<div class='myjustify margbothalf mysixteenpix mybold myunderline'>
					<?= Yii::t('SocialStatsModule.base', 'Follows:'); ?>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Follows in last 24h:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData FollowsOneDay'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Follows in last 7 days:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData FollowsOneWeek'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Follows in last 30 days:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData FollowsOneMonth'>...</span>
				</div>
				<div class='myjustify margbotquart'>
					<?= Yii::t('SocialStatsModule.base', 'Follows in last 3 months:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData FollowsOneQuarterY'>...</span>
				</div>
				<div class='myjustify margbothalf'>
					<?= Yii::t('SocialStatsModule.base', 'Follows in last 6 months:'); ?> <span class='myfifteenpix myturquoiseDark GeneralData FollowsOneHalfY'>...</span>
				</div>
				<br>
			</div>
		</div>
		<div class='mySmallerText margbotfull'><?= Yii::t('SocialStatsModule.base', 'General Data Process Time:'); ?> <span class='GeneralExec'>...</span></div>
		<div class='mySlightlySmallerText myjustify'>
			<span class='myita'><?= Yii::t('SocialStatsModule.base', 'Explanation of Logins data:'); ?></span>
			<br>
			<?= Yii::t('SocialStatsModule.base', 'Please note that HumHub does not record historical data regarding Logins..<br>
			This means that we are only ever seeing'); ?> '
			<span class='myita'><?= Yii::t('SocialStatsModule.base', 'Individual People\'s Logins'); ?></span> <?= Yii::t('SocialStatsModule.base', '(Unique Logins)'); ?>;
			<br>
			<?= Yii::t('SocialStatsModule.base', 'so, the numbers above show how many people logged in – or renewed their session – at least once in the given time..<br>
			This is why the Historical chart just below is interesting,'); ?>
			<br>
			<?= Yii::t('SocialStatsModule.base', 'because it records the number of Unique Logins every 24 hours, and displays them once per day..'); ?>
			<br>
			<?= Yii::t('SocialStatsModule.base', 'The rest of the data behaves more as you\'d expect..'); ?>
		</div>
		<br>
		
		<hr>
		
		<br><br>
		
		<?php use humhub\modules\social_stats\Assets; 
			$MyAssets = humhub\modules\social_stats\Assets::register($this);
		?>
		<script type='module' src='<?= $MyAssets->baseUrl.'/'.$MyAssets->js[0]; ?>'></script>
		<script type='module' src='<?= $MyAssets->baseUrl.'/'.$MyAssets->js[1]; ?>'></script>
		<script type='module' src='<?= $MyAssets->baseUrl.'/'.$MyAssets->js[2]; ?>'></script>
		<script type='module' src='<?= $MyAssets->baseUrl.'/'.$MyAssets->js[3]; ?>'></script>
		<script type='module' src='<?= $MyAssets->baseUrl.'/'.$MyAssets->js[4]; ?>'></script>
		<script src='<?= $MyAssets->baseUrl.'/'.$MyAssets->js[5]; ?>'></script>
		
		
		<div class='mycentertext margbotfull mysixteenpix mybold myunderline'>
			<?= Yii::t('SocialStatsModule.base', 'Historical data'); ?> - <span class='mySmallerText'><?= Yii::t('SocialStatsModule.base', '(click data titles to disable/enable)'); ?></span>
		</div>
		<div class='mycentertext margbotfull myita myturquoiseDark DailyChartReady MyDataLoading'><?= Yii::t('SocialStatsModule.base', 'Please wait for data to load..'); ?></div>
	
		<div class='myrighttext margbotquart'>
			<span class='PeriodSelect SelectOneWeek'><?= Yii::t('SocialStatsModule.base', 'Last Week'); ?></span> - <span class='PeriodSelect SelectOneMonth'><?= Yii::t('SocialStatsModule.base', 'Last Month'); ?></span> - <span class='PeriodSelect SelectOneSixMo mybold'><?= Yii::t('SocialStatsModule.base', 'Last 6 Months'); ?></span> - <span class='PeriodSelect SelectOneYear'><?= Yii::t('SocialStatsModule.base', 'Last Year'); ?></span> - <span class='PeriodSelect SelectOneAll'><?= Yii::t('SocialStatsModule.base', 'All'); ?></span>
		</div>
		
		<canvas class='myFullWidth margbothalf' id='MyDailyChart'></canvas>
		
		<div class='mycentertext margbotquart mySlightlySmallerText'>
			<?= Yii::t('SocialStatsModule.base', 'These are'); ?>
			<span class='myita'><?= Yii::t('SocialStatsModule.base', 'total'); ?>
			</span>
			<?= Yii::t('SocialStatsModule.base', 'numbers per day..'); ?>
			<br>
			<span class='mySmallerText'>
			    <?= Yii::t('SocialStatsModule.base', 'Please note that the data from this chart will build at the rate of once per day..'); ?>
			<br>
			    <?= Yii::t('SocialStatsModule.base', 'So you will only see data points appear once per day..'); ?>
			</span>
		</div>
				<div class='myjustify myrighttext margbothalf'>
					<span class='mySmallerText myturquoiseDark dlHistDataBU'><?= Yii::t('SocialStatsModule.base', 'download backup of this data'); ?></span>
				</div>
		
		<span class='mySmallerText'><?= Yii::t('SocialStatsModule.base', 'Historical Chart Process Time:'); ?> <span class='DailyExec'>...</span></span>
		
		<br><br>
		
		<hr>
		
		<br><br>
		
		<div class='mycentertext margbotfull mysixteenpix mybold myunderline'>
			<?= Yii::t('SocialStatsModule.base', 'Hourly Activity'); ?> - <span class='mySmallerText'><?= Yii::t('SocialStatsModule.base', '(click data titles to disable/enable)'); ?></span>
		</div>
		<div class='mycentertext margbotfull myita myturquoiseDark HourlyChartReady MyDataLoading'><?= Yii::t('SocialStatsModule.base', 'Please wait for data to load..'); ?></div>
		
		<?php
			$ThisTimeZone=\Yii::$app->getTimeZone(); 
			/* echo $MyBR.$ThisTimeZone."; date('T'): ".date('T')."; date('P'): ".date('P')."; date('P') short: ".substr(date('P'),0,3)."; just city: ".substr($ThisTimeZone,(strpos($ThisTimeZone,'/')+1));  */
		?>
		
		<div class='myrighttext margbotquart'>
			<?= Yii::t('SocialStatsModule.base', 'Change TimeZone'); ?> <span class='mySmallerText'><?= Yii::t('SocialStatsModule.base', '(server time is'); ?> <?= substr($ThisTimeZone,(strpos($ThisTimeZone,'/')+1)).' - UTC'.substr(date('P'),0,3); ?>)</span>: &emsp; 
			<span class='HourlyChartSelect SelectServerMinusThree'>-3h</span>
			 &emsp;–&emsp; 
			<span class='HourlyChartSelect SelectServerMinusTwo'>-2h</span>
			 &emsp;–&emsp; 
			<span class='HourlyChartSelect SelectServerMinusOne'>-1h</span>
			 &emsp;–&emsp; 
			<span class='HourlyChartSelect SelectServerTime mybold'><?= Yii::t('SocialStatsModule.base', 'Server Time'); ?></span>
			 &emsp;–&emsp; 
			<span class='HourlyChartSelect SelectServerPlusOne'>+1h</span>
			 &emsp;–&emsp; 
			<span class='HourlyChartSelect SelectServerPlusTwo'>+2h</span>
			 &emsp;–&emsp; 
			<span class='HourlyChartSelect SelectServerPlusThree'>+3h</span>
		</div>
		
		<canvas class='myFullWidth margbothalf' id='MyHourlyBreakdownChart'><?= Yii::t('SocialStatsModule.base', 'Loading..'); ?></canvas>
		
		<div class='mycentertext margbotfull mySlightlySmallerText'>
			<?= Yii::t('SocialStatsModule.base', 'These are'); ?> <span class='myita'><?= Yii::t('SocialStatsModule.base', 'total'); ?></span> <?= Yii::t('SocialStatsModule.base', 'numbers from the last 30 days at each hour; you would divide these numbers by 30 to get an average..'); ?>
		</div>
		
		<span class='mySmallerText'><?= Yii::t('SocialStatsModule.base', 'Hourly Activity Process Time:'); ?> <span class='HourlyExec'>...</span></span>
		
		<br>
		
		<span class='testarea'></span>
		<br>
		
		<!-- Begin desperation -->
		<div class='mycentertext margbothalf mySlightlySmallerText'>
			<?= Yii::t('SocialStatsModule.base', 'if you find this module useful, please consider a donation'); ?>
			<br>
			<?= Yii::t('SocialStatsModule.base', 'it\'d really, really, really, really,'); ?>
			<br>
			<?= Yii::t('SocialStatsModule.base', 'really, really, really help..'); ?>
		</div>
		<div id="donate-button-container" class='mycentertext'>
			<div id="donate-button"></div>
			<script <?= Html::nonce() ?> src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
			<script <?= Html::nonce() ?>>
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
		<!-- i wish i could say that's the end of it.. -->
	</div>
</div>

