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

use humhub\modules\admin\widgets\AdminMenu;

use humhub\commands\CronController;
use humhub\modules\queue\Events;
use humhub\modules\queue\Module;
use yii\queue\Queue;
use humhub\components\ModuleManager;


return [
	'id' => 'social_stats',
	'class' => 'humhub\modules\social_stats\Module',
	'namespace' => 'humhub\modules\social_stats',
	'events' => [
		['class' => AdminMenu::className(), 'event' => AdminMenu::EVENT_INIT, 'callback' => ['humhub\modules\social_stats\Events', 'onAdminMenuInit']],
		['class' => CronController::class, 'event' => CronController::EVENT_ON_DAILY_RUN, 'callback' => ['humhub\modules\social_stats\Events', 'onDailyCronRun']],
		/* ['class' => CronController::class, 'event' => CronController::EVENT_ON_HOURLY_RUN, 'callback' => ['humhub\modules\social_stats\Events', 'onDailyCronRun']], */
		],
	];
?>