# Interview Board

This project was created based on a question from StackOverflow where a new developer needed some help. In the end, I decided it would be easier for me to spend a few hours writing a small project for him to show him coding styles, how to do basic queries to pull data from a database and how to display that data to the user. Since it is built to track interview information, I wanted to also integrate sessions and authentication to keep everything secure. In the end, this web based application shows basic and advanced CRUD utilizing PHP, MySQL, HTML, CSS, JavaScript (jQuery), and AJAX (jQuery).

## Installation

To install this application, download or clone the project. Then, visit `http://yoursite.com/install/` and walk through the installation!

## User Interface

The user interface uses Bootstrap 4.x from [getbootstrap.com](https://getbootstrap.com/).

The icons are from Font Awesome [fontawesome.com](https://fontawesome.com).

## Features

Track the following data models and attributes:

### Interviews

Here's a list of actions for interviews:

 - List Interviews
 - Create Interview
 - Update Interview
 - Delete Interview
 - Read Interview

Here's a list of the attributes for each interview:

```
First Name
Last Name
E-Mail Address
Phone Number
Interview Date
Interview Method
Questions asked by interviewee
Additional notes
Whether or not to hire interviewee
Answers to questions asked to interviewee
Created Date/Time
Modified Date/Time
```

-----

### Questions

Here's a list of actions for questions:

 - List Questions
 - Create Questions
 - Update Questions
 - Delete Questions (removes answers from previous interviews)
 - Read Question

Here's a list of the attributes for each question:

```
Name
Question
Active
Created Date/Time
Modified Date/Time
```

-----

#### Users

Here's a list of actions for users:

 - List Users
 - Create Users
 - Update Users
 - Delete Users
 - Read Users

Here's a list of the attributes for each user:

```
First Name
Last Name
E-Mail Address
Password
Phone Number
Active
Created Date/Time
Modified Date/Time
Last Login Date/Time
```

## Releases

This section will be used to define releases.

```
0.0.1 - Users, Questions, Interview Tracking, and Scheduling.
```

## Future Features

Here's a list of features that I plan to add to this application. When a feature gets added, it will be removed from this list and added above.

1) **STARTED** - Move actions into classes/models for better usability and code reusing
2) Schedules - Schedule an interview and send reminders via e-mail.
3) Jobs - Create job postings with information about each job.
4) Candidates - Allow registration of candidates so they can sign in and apply for jobs.
5) Pre-Interview Questionnaire - Add a pre-interview questionnaire.
6) Questions to Jobs - Allow specific questions to be assigned to specific job postings which will then be used during the interview process instead of the default all questions that are active.
7) Reports - Generate reports based on different data points (this needs to be further defined)
8) Search - Add search capabilities to all feature sections
9) Mobile - Make the UI more user friendly (or create another project and use Ionic to create a mobile app??? will require an api!!!)

## Ideas

These are items that I am still pondering about doing.

1) ~~Use jQuery->ajax to load table data (will be good for pagination as well since there is none right now)~~
2) ~~Implement pagination (even if we do not do number 2, this should still be done at some point)~~
3) Create a demo application (reset data every 12 or 24 hours)
4) Start using releases and branches appropriately

## Recent Additions

```
2019-08-05 - Added an installation wizard to help installing the application.
2019-08-06 - Added custom page titles
2019-08-07 - Added pagination class and simply pagination to all module indexes
2019-08-07 - Added categories for questions
2019-08-08 - Added dynamic questions to interviews
2019-08-08 - Started creating a small API for use with AJAX requests (requires current active session so it cannot be used externally)
2019-08-14 - Added Schedules page with FullCalendar
2019-08-17 - Changed color of top header background and fixed z-index
2019-08-17 - Added 'active' class for main navigation
2019-08-17 - Changed 'success' classes to 'info' to match color scheme
2019-08-17 - Added 'cancel' buttons
2019-08-17 - Changed text size on form info text
2019-08-17 - Added AWS SDK for SES integration
2019-08-17 - Added AWS Regions table to database
2019-08-17 - Change input borders to match color scheme
2019-08-19 - Changed auth screens by adding a box around the forms
2019-08-19 - Added form validation via jQuery Validate
2019-08-19 - Added Sign Up form (which can be turned off)
2019-08-20 - Added reset.php for resetting password
2019-08-20 - Added tabs to settings to help organize it
2019-08-21 - Migrated "User" actions to User() class
2019-08-21 - Migrated "My Account" to User() class
2019-08-21 - Migrated "Question Category" actions to QuestionCategory() class
2019-08-21 - Migrated "Question" actions to Question() class
2019-08-21 - Migrated "Interview" actions to Interview() class
2019-08-21 - Added "InterviewAnswer" class for actions used in "Interview" actions
2019-08-21 - Migrated "Settings" actions to Setting() class
```

## Screenshots

Need to spend some time creating snapshots and adding them here for people to see.
