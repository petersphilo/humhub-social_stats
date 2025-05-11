
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
				
			/* -- Begin dl data -- */
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
			
			
			$('.dlAllUsers').on('click',function(){
				MyCurrentGetURL=window.location.search; 
				if(MyCurrentGetURL.length){MyNewGetURL=MyCurrentGetURL+'&dlAllAccnts=Yes'; }
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
			/* -- End dl data -- */
				
				
				}); 
		