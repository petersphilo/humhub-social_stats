
			$(function(){
				var MyDailyChartSelector=$('#MyDailyChart'),
					MyHourlyBreakdownChartSelector=$('#MyHourlyBreakdownChart'),
					
					DailyLoginsFull=[],
					DailyPostsFull=[],
					DailyCommentsFull=[],
					DailyLikesFull=[],
					DailyFollowsFull=[],
					
					DailyLoginsSixMo=DailyLoginsFull.slice(-182),
					DailyPostsSixMo=DailyPostsFull.slice(-182),
					DailyCommentsSixMo=DailyCommentsFull.slice(-182),
					DailyLikesSixMo=DailyLikesFull.slice(-182),
					DailyFollowsSixMo=DailyFollowsFull.slice(-182),
					
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
					
					MyCurrentGetURL,
					MyNewGetURL,
					MyFetchURL;
				
				MyCurrentGetURL=window.location.search; 
				/*
				if(MyCurrentGetURL.length){MyNewGetURL=MyCurrentGetURL+'&'; }
				else{MyNewGetURL='./?'; }
				*/
				var GDPost=$.post(
					MyCurrentGetURL,
					{GeneralData:'Yes'},
					function(GData){
						Object.keys(GData).forEach(function(key){
							MyTestText+=MyBR+key+': '+GData[key]; 
							GDSelector='.'+key; 
							$(GDSelector).text(GData[key]); 
							}); 
						},
					"json"
					); 
				GDPost.done(function(){
					$('.GeneralDataReady').removeClass('MyDataLoading').hide(); 
					}); /*
				GDPost.fail(function(){
					console.log('i failed'); 
					}); 
				GDPost.always(function(){
					console.log('i tried'); 
					}); */ 
				
				
				$('.dlInactiveUsers').on('click',function(){
					MyCurrentGetURL=window.location.search; 
					if(MyCurrentGetURL.length){MyNewGetURL=MyCurrentGetURL+'&dlInactiveAccnts=Yes'; }
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
						.catch(() => alert('something went wrong..'));
					}); 
				
				
				$('.dlHistDataBU').on('click',function(){
					MyCurrentGetURL=window.location.search; 
					if(MyCurrentGetURL.length){MyNewGetURL=MyCurrentGetURL+'&dlHistDataBU=Yes'; }
					else{MyNewGetURL='./?dlHistDataBU=Yes'; }
					fetch(MyNewGetURL)
						.then(resp => resp.blob())
						.then(blob => {
							var Myurl = window.URL.createObjectURL(blob);
							const TempdlLink = document.createElement('a');
							TempdlLink.style.display = 'none';
							TempdlLink.href = Myurl;
							TempdlLink.download = 'HistoricalChartData.csv.gz';
							document.body.appendChild(TempdlLink);
							TempdlLink.click();
							window.URL.revokeObjectURL(Myurl);
							TempdlLink.remove();
							})
						.catch(() => alert('something went wrong..'));
					}); 
				
				
				
				
				/* Begin Historical Data */
				/*  */
				
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
				
				
				var DailyPost=$.post(
					MyCurrentGetURL,
					{HistoricalDailyData:'Yes'},
					function(DailyData){
						DailyLoginsFull.length = 0;
						DailyPostsFull.length = 0;
						DailyCommentsFull.length = 0;
						DailyLikesFull.length = 0;
						DailyFollowsFull.length = 0;
						
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
						
						$('.DailyExec').text(DailyData.DailyExec); 
						
						MyDailyChart.data.datasets[0].data=DailyLoginsFull; 
						MyDailyChart.data.datasets[1].data=DailyPostsFull; 
						MyDailyChart.data.datasets[2].data=DailyCommentsFull; 
						MyDailyChart.data.datasets[3].data=DailyLikesFull; 
						MyDailyChart.data.datasets[4].data=DailyFollowsFull; 
						MyDailyChart.update(); 
						},
					"json"
					);
				DailyPost.done(function(){
					$('.DailyChartReady').removeClass('MyDataLoading').hide(); 
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
				/*  */
				/* End Historical Data */
				
				
				/* Begin Hourly Data */
				/*  */
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
				
				
				var HourlyPost=$.post(
					MyCurrentGetURL,
					{HourlyActivityData:'Yes'},
					function(HourlyData){
						HourlyBreakdownLogins.length = 0;
						HourlyBreakdownPosts.length = 0;
						HourlyBreakdownComments.length = 0;
						HourlyBreakdownLikes.length = 0;
						HourlyBreakdownFollows.length = 0;
						/**/
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
						
						$('.HourlyExec').text(HourlyData.HourlyExec); 
						
						MyHourlyBreakdownChart.data.datasets[0].data=HourlyBreakdownLogins; 
						MyHourlyBreakdownChart.data.datasets[1].data=HourlyBreakdownPosts; 
						MyHourlyBreakdownChart.data.datasets[2].data=HourlyBreakdownComments; 
						MyHourlyBreakdownChart.data.datasets[3].data=HourlyBreakdownLikes; 
						MyHourlyBreakdownChart.data.datasets[4].data=HourlyBreakdownFollows; 
						MyHourlyBreakdownChart.update(); 
						/**/
						},
					"json"
					);
				HourlyPost.done(function(){
					$('.HourlyChartReady').removeClass('MyDataLoading').hide(); 
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
					
				/*  */
				/* End Hourly Data */
				
				
				}); 
		