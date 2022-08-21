# Exercise - Alerting Tool

## Intro
At NETPLANET GmbH we obviously have to deal with a lot of data and multiple datatypes. Infrastructure needs to be up 24/7 and therefore monitoring our systems is crucial.

Therefore, our Team needs to have access to the data and should be able to easily maintain it and get notified if something goes wrong.

Try to finish the following exercise, within a short period of time, consider putting not more than one day in of work into the exercise.

## Description
We want to implement a tiny lightweight monitoring system where users get informed via different ways when a new alert appears.

Therefore we need to implement the following functionality by providing corresponding API Endpoints and setup a lightweight vueJS Frontend to visually interact with the endpoints.

Please think about best-practices and error handling while implementing the task. Feel free to add comments and notes.

**!! You don't need to consider authentication, imagine you only have access to the API Endpoints within a secure environment.**

**!! The VueJs Boilerplate will be provided as well as the laravel instance.**

###**List current Alerts**

- The GUI Entrypoint should provide a list of Alerts
- Visualize the difference of alerts (already acknowledged and open/new) 

###**Maintain contacts**

- CRUD functionality
- a contact has a name a value and a type (sms,pager,email)

###**Maintain contact-groups**

- CRUD functionality
- contact groups have a name and contain one or more contacts.
additionally groups have a certain state. (active|inactive).
ONE or MORE groups can be active!
- Assign contacts to one or many contact-groups or remove them from current groups

###**Receive System Alerts**

It should be possible to receive new alerts from any other system.
Received Alerts should be stored in the database with the time they have been received.

In general, new alerts need to be acknowledged by the user and will appear as relevant and new as long as an acknowledgement happened.

###**(Auto-) Acknowledge Alerts [commits]**

Provide a way to acknowledge ALL open alerts at once, there is no need to acknowledge single alerts one by one.

Further, provide a 'snooze' or auto-acknowledgement functionality. 
It means if this functionality gets called all new alerts will be automatically acknowledged for a certain timeframe. e.g. 10Minutes. After that time alerts are new and need to be acknowledged manually again.
You can think about the snooze or delay function of your alarm clock.
Hint: you can create a commit in the future to achieve this functionality or change the latest acknowledgement_timestamp. 

###**Send Notifications**

When new alerts appear which are not auto-acknowledged make sure to inform the users within the 
currently active user group via the corresponding contact type (sms,pager,email)

For simulation of sending Notifications you can simply use the "NotificationTrait" provided by us.


###**Workflow**

- 1. A new alert appears via API Call
- 2. Store in databse
- 2.a check if autoacknowledge (snooze) is active and set confirmed flag if necessary
- 2.b if autoacknowledge is not active 
- 2.b.1 Query active groups
- 2.b.2. Send messages to members of active groups (message type based on contact type) 


## Requirements
- php >= 7.4
- composer 
- MySql >= 5.7

## Database structure

***core_alarms***

new alerts will be stored with error message and timestamp, if messages are acknowledged flag changes and time is saved) 
- id
- create_timestamp
- message
- confirmed
- confirm_timestamp


***contacts***

holds all available contacts; type can be 'pager' or 'sms' or 'email' currently
- id
- phone
- name
- type 

***groups***

- id
- name
- standby (if TRUE send notifications to contacts of this group)

***contacts_groups***

Contacts <-> Groups; many-to-many relationship
- id
- group_id
- contact_id

***commits***

- id
- last_commit

#How to submit
If not communicated different, we invited you to a private github repository 
where you can submit the final project. 

If you have any questions do not hesitate to contact us.

Happy coding :)
