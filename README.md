

## About Project

This is project XX

## Technologies used:

* uuid generator: composer require webpatser/laravel-uuid
* flags (https://github.com/lipis/flag-icons) use (import "/node_modules/flag-icons/css/flag-icons.min.css";)

## ChangeLog

# First batch (pushed 03.11.2022)

#### 2022.09.29

* settin up the project;
* User, Country, Town models created
* controllers store method created 
* user country town tests made

#### 2022.09.30

* Club model created
* Club controller created

#### 2022.10.29

* JWT implementation
* Updated blade templates for dashboard 
* Added User model blades
* added column into user table with column name disabled, it stores true or false 

#### 2022.11.01

* added new column 'logins' into users table it stores last 20 logins information
* implement method to extract user ip address and store it into databased table
* updating login logic as it now checks if user is disabled or nor 

#### 2022.11.02

* added blades for Country model
* added modal boxes on .blade.php templates to have create, view or update page to pop up in index view.

# Second batch (...)

#### 2022.11.03

* added blade template for Town model
* implemented it add, delete, update methods, request validation

#### 2022.11.04

* added blade template for Club model
* implemented it add, delete, update methods, request validation
* updated club migration changing foreignt keys constrains now user_id and town_id can be nullable
* Using JS implemented dynamic dependenced dropdown for country->town selection 

#### 2022.11.19

* added blade templates for Player model
* implemented it add, delete, update methods, request validation

#### 2023.01.23

* added back to dashboard button on each index blade to navigate back to dashboard page.

#### 2023.02.03
* Corrected add player form css
* Names and surnames tables created
* Names and surnames controllers created
* NamesSurnames blades created

#### 2023.02.12
* added validation for names and surnames form requests;
* implemented filter to filter results by country;

#### 2023.02.26

* HOTfix fixed bug where checking user last   logins showing viewing user logins instead specific user that to be checked;
* HOTfix when new user register and logged for first time app crashes becouse of no last logins records;
* Updated update modal for names and surname that now can select from dropdown list;
* fixed bug in update surname modal;
* General code sorting(removed commented lines);
* added blade index file with form;
* update players controller adding new method to generate player;
* created a new Service file for processing request for generating new random player;
* added methods in service file; 

#### 2023.02.27

* updated generate player form, (youth quality field added);
* added JQuery for disabling youth quality field if generating type is not youth selected;
* updated generate player service, youth player generating logic implemented;
* added button in player blade and implemented its metod 'clear' to truncate all records from table - players in database; 
* Fixed bug when after loged in showin most recent login instead one before;

#### 2023.02.28

* changes in namesSurnames controller - now corecting inputed value to first uppercase and rest to lowercase letters;
* added search in names surnames;

#### 2023.03.02

* <del>added button in dashboard blade for navigating to generate teams blade page;</del>
* removed underline style from buttons in dashboard blade;
* created controller - generatorController
* renamed button in dashboard from generate player to generatePlayer/team;
* relocated from playerController some methods to generatorController: generatorIndex() -> index() and generatePlayer();
* added new method generateTeam();
* implemented JS script for town selection dependant on selected country;

#### 2023.03.27

* GenerateTeamService and baseTeamProcess service implementated with its logic;
* Implemented auto generating team players of 18 players;

#### 2023.04.02

* added blades and css for generated team and it's player list;
* added fire button and its method to dismiss player from team and set  that player without a club;
* added player count indicator to show how many players in team's player list;

#### 2023.04.14

* Created match schedule table and model;

#### 2023.05.21

* A new field in register page club name and country, required for creating a team;
* Update registeredController, now as new user register a team automaticlly created for him;
* Added accountinfo at dashboard; it has method to assign active clube for the user; 

#### 2023.05.22

* A new model FriendlyInvitation was created;

#### 2023.05.26

* Implemented invite friendly logic;
* Implemented host friendly logic;
* Implemented acceping friendly logic;
* MatchService queries added;

#### 2023.05.27

* Fixed bug in query when inviting friendly.. <del>team with already accepted match can invite again....</del>;
* implemented other users hosted matches and its logic and methods.

#### 2023.05.28

* minnor changes in blade layout;
* now when inviting host edvertismenting team for match it sent pending request for match;
* user can accept pending matches offers and generate prematch record;

#### 2023.05.30

* match report blade created;

#### 2023.06.04

* added cron command that checks every 30 min table matchSchedule. All found records and if matchday and time and set that model status to accepted; 
* added new column to match_schedule table "time";
* added new column to country table "timezone";
* updated fillMatchData method in matchSchedule model with new field timezone which extracted from home_team;
<del>//TODO update Country blades and forms by adding new field timezone;</del>
<del>// Implement match logic creating basic match engine; </del>

#### 2023.08.02

* updated country blade added timezone field to both add and update forms modal; 
* ypdated countryController passing timezone  list array;
* created config/timezone.php file with timezones";
* added new provider class "TimezonesServiceProvider" for the custom configuration file;

 #### 2023.08.06

* Match engine implementation;
* Command to process matches;
* Match service created;

 #### 2023.09.08

* started implementing match report;
 #### 2023.09.09

* updating match report;
* baseMatchEvents class created;
* added new fields to match_schedules table (home_goals,  away_goals, home_shots,  away_shots, home_on_target, away_on_target);




