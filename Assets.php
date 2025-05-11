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
use yii\web\AssetBundle;
//use yii\web\JqueryAsset; 

class Assets extends AssetBundle
	{
		public $sourcePath = '@social_stats/assets';
		/*
		$this->js = [
			['chart.min.js', 'type' => 'module'],
			['chart.esm.js', 'type' => 'module'],
			['chart.mjs', 'type' => 'module'],
			['helpers.esm.js', 'type' => 'module'],
			['helpers.mjs', 'type' => 'module']
			]; 
		*/
		public $js = [
			['chart.min.js', 'type' => 'module'],
			['chart.esm.js', 'type' => 'module'],
			['chart.mjs', 'type' => 'module'],
			['helpers.esm.js', 'type' => 'module'],
			['helpers.mjs', 'type' => 'module'],
			['chunks/helpers.segment.js', 'type' => 'module'],
			['chunks/helpers.segment.mjs', 'type' => 'module']
			]; 
		/*
		$this->publishOptions = [
			'forceCopy' => true
			];
		*/
		//public $depends=[JqueryAsset::class]; 
	}