Approval
=============
A client approval plugin for [ResourceSpace](http://resourcespace.org/).

![Image](http://emrl.co/assets/img/approval.jpg)

For past few years, we have been using variations of this plugin in the daily operation of an [advertising agency](http://emrl.com/) in northern California. It has proven to be super useful and very reliable, and we're finally getting around to publishing it so other users of [ResourceSpace](http://resourcespace.org/) can benefit.

It is still missing quite a bunch of features we plan on adding, and has not really been prepared for public consumption so it may be a pain in the ass to install (sorry!) 

If you end up finding that this is useful to you, let us know!

How It Works
--------
When uploading or editing a resource, if this plugin is enabled you'll see an new option to add an approval form. When this option is enabled, a simple approval form will be displayed in the resource description, allowing for a client to choose  "Approved", " Not Approved - Minor Changes", or "Not Approved - Major Changes". In addition, the client can enter notes on the changes needed. Comments are stored, creating a history of the approval process over time. The client then enters their name and initials, and submits the form.

The results of the client's submission form are emailed to the users that are defined in the plugin's options.

Installation
--------
The plugin will be document in more detail soon, but for now here are the basics:

1. Copy files to Plugins folder
2. Activate plugin (Team Center > Manage Plugins > approval > Activate)
3. Create approval form resource field (Team Center > System Setup > Resource Types / Fields > [Type] > New Field)
   Set the 'Shorthand name' to exactly 'approval_form'
   For 'Field Type' you can choose 'Check box list', and for the 'Options' just enter one value: 'Yes'.
   The plugin will only show the Approval Form if the resource has the value 'Yes' for the 'approval_form' resource type field.
   All other fields are optional.
4. Configure plugin (Team Center > Manage Plugins > approval > Options)

Contact
--------
* <http://emrl.com/>
* <https://www.facebook.com/advertisingisnotacrime> 

License
--------
Creative Commons - Attribution - Share Alike license.  
