# Social Stats
This module provides general statistics on overall activity, with charts of hourly and daily activity

### Please Note

Historical data will take time to populate!  
you will see the chart build up every day..  
The first day, it'll look empty..

This is where Master Yoda should intervene with some sort of aphorism about patience..

### Explanation of Logins data:

Please note that HumHub does not record historical data regarding Logins..  
This means that we are only ever seeing '*Individual People's Logins*' (Unique Logins);  
so, the numbers above show how many people logged in – or renewed their session – at least once in the given time..  
This is why the Historical chart just below is interesting,  
because it records the number of Unique Logins every 24 hours, and displays them once per day..  
The rest of the data behaves more as you'd expect..  
<br><br>

## Installation - Now Available in the Store!

Thanks to the HumHub Community Managers, `Social Stats` is now available in the Modules 'Store' within your HumHub installation!

As an Admin, go to `Administration`, then `Modules`, then you can search for `Social Stats`

Thank You!

### Please Note

If you're having trouble with the charts loading..  
Please add the following to the `.htaccess` file that is at the root of your HumHub installation:
```
AddType text/javascript .mjs
```
If you can't edit your .htaccess file, usually simply reloading the page works..

<br><br>

## Donationware -- Consider a Donation!!

Your doantion would really, really, really, really help!  
https://www.paypal.com/donate/?hosted_button_id=AEA7Q4V5RMY4S

Thank You!

<br><br>

## ScreenShots

This is pretty much how it looks:

![ScreenShot 1](/assets/screen-1.jpg?raw=true "ScreenShot 1")  
![ScreenShot 2](/assets/screen-2.jpg?raw=true "ScreenShot 2")  
![ScreenShot 3](/assets/screen-3.jpg?raw=true "ScreenShot 3")

<br><br>

## Other ways to install

### Installation (Using Git Clone)

- Clone the social_stats module into your modules directory
```
cd protected/modules
git clone https://github.com/petersphilo/humhub-social_stats.git social_stats
```

- Go to Admin > Modules. You should now see the `Social Stats` module in your list of installed modules

- Click "Enable". This will install the module for you

Eventually, i hope to have this module in the 'store'

### Installation (Manually, using Release zip - for those not comfortable with the command line)

- Download the zip file from [/releases/latest](https://github.com/petersphilo/humhub-social_stats/releases/latest)

- Upload it to the `protected/modules` directory of your HumHub installation and expand it (then delete the zip file)

- Go to Admin > Modules. You should now see the `Social Stats` module in your list of installed modules

- Click "Enable". This will install the module for you

Eventually, i hope to have this module in the 'store'