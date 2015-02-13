=== NC Notification Center ===
Author URI: http://ralv.es
Plugin URI: http://inglesnarede.com.br
Author: Renato Alves // Blog Inglês na Rede
Donate link: 
Tags: notice, notification, simple, note, announce, announcement
Requires at least: 3.8
Tested up to: 4.1

The NC Notification Center is a fork of the Simpe Notices plugin from Pippin Williamson.

It adds a notication center using custom post type. The notifications are displayed for logged in and non logged in users.

== Description ==

The NC Notification Center is a fork of the Simpe Notices plugin from Pippin Williamson.

It adds a notication center using custom post type. The notifications are displayed for logged in and non logged in users.

The Simple Notices plugin from Pippin Williamson is a great plugin, but we, from Blog Inglês na Rede, needed more control and more improvements from it. So we decided to fork it and improve it ourselves.

The NC Notification Center provides a shortcode where the notification will appear, in this way, you can put the notification in different pages and strategic locations, using the same code.

Each notification comes with a title, content area and a close button that allows the current user to remove the notification after reading it. If the user is logged in, the notification ID will be permanently stored in their user meta, and so will never shown again. If the user is not logged in, the ID of the notification will be stored in a cookie in the browser and also will not appear again (unless the user clear his/her browser cookie).

Also, after clicking the close button, the necessary js and css are removed, preventing the download of unnecessary assets.

@todo

- Add screenshots
- Allow theme developers to add their own css in their templates (like bbpress and buddypress do)
- Allow featured image in the notifications
- Create pot file // Translation
- Add more secutiry when user is logged in (Nounce)

== Installation ==

1. Upload nc-notification-center to wp-content/plugins
2. Click "Activate" in the WordPress plugins menu
3. Click Notification in the left dashboard menu
4. Create a new notification and click Publish

== Screenshots ==

== Changelog ==

= 1.0 =

Initial release.

== Upgrade Notice ==
