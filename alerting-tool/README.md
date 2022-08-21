# Rename .env.example to .env in both folders

# in Laravel project:
- composer install
- php artisan key:generate
- php artisan migrate
- php artisan passport:install
- php artisan serve

# in Vue project: 
- npm install
- npm run build
- npm run serve

# - Alerting Tool

## Description
The aim of this project is to  monitor systems to deal with a lot of data and multiple datatypes by getting notified if something goes wrong.

It's a monitoring system where users get informed via different ways when a new alert appears.

## Functionalities
### **List current Alerts**
- The GUI Entrypoint provide a list of Alerts
- Visualize the difference of alerts (already acknowledged and open/new) 

### **Maintain contacts**
- CRUD functionality
- a contact has a name a value and a type (sms,pager,email)

### **Maintain contact-groups**
- CRUD functionality
- contact groups have a name and contain one or more contacts.
additionally groups have a certain state. (active|inactive).
ONE or MORE groups can be active!
- Assign contacts to one or many contact-groups or remove them from current groups

### **Receive System Alerts**
It should be possible to receive new alerts from any other system.
Received Alerts should be stored in the database with the time they have been received.
In general, new alerts need to be acknowledged by the user and will appear as relevant and new as long as an acknowledgement happened.

### **(Auto-) Acknowledge Alerts [commits]**
It's possible to acknowledge ALL open alerts at once, there is no need to acknowledge single alerts one by one.
Further, having the option 'snooze' or auto-acknowledgement functionality. 
It means if this functionality gets called all new alerts will be automatically acknowledged for a certain timeframe. e.g. 10Minutes. After that time alerts are new and need to be acknowledged manually again.

### **Send Notifications**
When new alerts appear which are not auto-acknowledged, the system inform users within the currently active user group via the corresponding contact type (sms,pager,email)

### **How it works**
- 1. A new alert appears via API Call
- 2. Store in databse
- 2.a check if autoacknowledge (snooze) is active and set confirmed flag if necessary
- 2.b if autoacknowledge is not active 
- 2.b.1 Query active groups
- 2.b.2. Send messages to members of active groups (message type based on contact type) 


## Technologies
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
- id
- phone
- name
- type (a type can be 'pager' or 'sms' or 'email')

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
