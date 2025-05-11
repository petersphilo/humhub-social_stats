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
use humhub\models\Setting;

class Module extends \humhub\components\Module {
	public function enable()
	{
		parent::enable();
		
		$social_stats=Yii::$app->getModule('social_stats'); 
		
		if ($social_stats->settings->get('showDesperation') == '') {
			$social_stats->settings->set('showDesperation', 1); 
			}
		}
	}
