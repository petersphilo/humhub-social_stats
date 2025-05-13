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

namespace humhub\modules\social_stats\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\JqueryAsset; 

class Assets extends AssetBundle
	{
		public $sourcePath = '@social_stats/resources';
		/*
		// throws up a bunch of errors without the 'type' => 'module' but it works on first load..
		public $js = [
			['js/chart.min.js', 'type' => 'module'],
			['js/chart.esm.js', 'type' => 'module'],
			['js/chart.mjs', 'type' => 'module'],
			['js/helpers.esm.js', 'type' => 'module'],
			['js/helpers.mjs', 'type' => 'module'],
			['js/chunks/helpers.segment.js', 'type' => 'module'],
			['js/chunks/helpers.segment.mjs', 'type' => 'module']
			]; 
		*/
		public $js = [
			['js/chart.min.js'],
			['js/chart.esm.js'],
			['js/chart.mjs', 'type' => 'module'],
			['js/helpers.esm.js'],
			['js/helpers.mjs', 'type' => 'module'],
			['js/chunks/helpers.segment.js'],
			['js/chunks/helpers.segment.mjs', 'type' => 'module']
			]; 
		
		public $depends=[JqueryAsset::class]; 
	}