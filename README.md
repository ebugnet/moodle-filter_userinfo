# moodle-filter_userinfo

## Project

One step to use moodle for serious gaming : text personnalisation.
More info for using moodle in gammification (in french) : https://eric.bugnet.fr/gamifier-moodle/

This code add filter for LMS Moodle to let Moodle adapt text with personnal user information.

## Install

1. Copy the files to : /moodle/filter/userinfo
2. On your moodle instance, go to Administrtation block > Site administration > Notifications, and install the new plugin.
3. Go to Administration block > Site administration > Plugins > Filters > Manage filters and activate the userinfo filter.

Tested on Moodle 3+.

## Usage

In any text entered in moodle text arrea (atto), you can use balise like [USER:firestname].
When you are not in edit mod, filter change the balise with the real user firstname.

You can use all user informations inserted in profile page, like :
* [USER:firstname]
* [USER:surtname]
* [USER:username]
* [USER:email]
* [USER:picture]
* [USER:institution]
* [USER:phone1]
* [USER:country]
* [USER:...]

But, you can also use user group information :
* [USER:group_id]
* [USER:group_name]
* [USER:group_picture]
* [USER:group_picture_large]

And personnal added information, asked with Administration block > Site administration > Users > Accounts > User profile fields
* [USER:profile_field_short_name]

## Next step

I hope I could make an atto plugin to insert this balises... Work in progress...
