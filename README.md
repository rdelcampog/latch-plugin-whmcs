LatchWHMCS v1.0 (admin panel)
==================

Keep the author active, buy it some coffee <3

[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=korros&url=https%3A%2F%2Fgithub.com%2FKorrosivo%2Flatch-plugin-whmcs) 
[![Donate some coffee](https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=U557BVZEZ24DU) 

##LatchWHMCS installation guide

###PREREQUISITES 
* WHMCS version 5.0 or later.
* **"Application ID"** and **"Secret"**, (fundamental values for integrating Latch in any application).
  * It’s necessary to register a developer account in [Latch website](https://latch.elevenpaths.com). On the upper right side, click on **"Developer area"**.

###INSTALLING THE ADDON MODULE IN WHMCS

####OBTAINING APPLICATION ID & SECRET
* After creating and activating an account in [Latch website](https://latch.elevenpaths.com), the admin will be able to create applications with Latch and access to developer documentation, including existing SDKs and plugins. The admin has to access again to [Developer area](https://latch.elevenpaths.com/www/developerArea), and browse his applications from **"My applications"** section in the side menu.

* When creating an application, two fundamental fields are shown: **"Application ID"** and **"Secret"**, keep these for later use. There are some additional parameters to be chosen, as the application icon (that will be shown in Latch) and whether the application will support OTP (One Time Password) or not (**_not supported by this addon module_**).

####USING ADDON MODULE

* Once the administrator has downloaded the addon module, it has to be upload to "{whmcs_path}/modules/addons/"
* Login as admin in WHMCS and go to Setup > Addon Modules using the top navbar
  * Activate the module **>> Latch WHMCS (admin)**
  * Press on "Configure" and fill **Application ID** and **Secret key** inputs using the the previously obtained values ([image](https://github.com/Korrosivo/latch-plugin-whmcs/#configure-the-addon-module))
  * Use the checkboxes to allow admin role groups to pair their accounts and Save Changes
* Go to **"Addons > Latch WHMCS (admin)"** using the top navbar to pair your account with Latch.
* Using Latch app, generate a pairing code, fill the box in that screen and press the blue button ([image](https://github.com/Korrosivo/latch-plugin-whmcs/#pair-an-account))
* If everything is ok, your account is now paired and you can control login using Latch app

###UNINSTALLING THE ADDON MODULE IN WHMCS
* To remove the addon module, the administrator has to click on **"Deactivate"** button in Setup > Addon Modules screen.
  * **Important:** deactivating the module wipes LatchWHMCS database. You'll have to pair accounts again if you want to use the module in the future.
* After deactivating the addon module, you can delete the files from the server whenever you want.

###SCREENSHOTS
####CONFIGURE THE ADDON MODULE
![Configure the module](http://i58.tinypic.com/2rervax.png)
####PAIR AN ACCOUNT
![Pair an account](http://i61.tinypic.com/23h7xw5.png)
####UNPAIR AN ACCOUNT
![Unpair an account](http://i62.tinypic.com/33ysu0w.png)
