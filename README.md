# Interview Portal

This project was created based on a question from StackOverflow where a new developer needed some help. In the end, I decided it would be easier for me to spend a few hours writing a small project for him to show him coding styles, how to do basic queries to pull data from a database and how to display that data to the user. Since it is built to track interview information, I wanted to also integrate sessions and authentication.

## Setup

To set this project up in your own environment, clone the project to your server using `git`. Once cloned, create a database and import the database from `database/database.sql`.

Next, move `common/config.php.example` to `common/config.php` and add your database credentials!

## User Interface

The user interface uses Bootstrap 4.x from [getbootstrap.com](https://getbootstrap.com/).

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

## Future Features

Here's a list of features that I plan to add to this application. When a feature gets added, it will be removed from this list and added above.

```
1) Schedules - Schedule an interview and send reminders via e-mail.
2) Jobs - Create job postings with information about each job.
3) Candidates - Allow registration of candidates so they can sign in and apply for jobs.
4) Pre-Interview Questionnaire - Add a pre-interview questionnaire.
5) Questions to Jobs - Allow specific questions to be assigned to specific job postings which will then be used during the interview process instead of the default all questions that are active.
6) Reports - Generate reports based on different data points (this needs to be further defined)
7) Search - Add search capabilities to all feature sections
```

## Ideas

These are items that I am still pondering about doing.

```
1) Move actions into classes/models for better usability and code reusing
2) Use jQuery->ajax to load table data (will be good for pagination as well since there is none right now)
3) Implement pagination (even if we do not do number 2, this should still be done at some point)
4) Create a demo application (reset data every 12 or 24 hours)
5) Start using releases and branches appropriately
```

## Screenshots

Need to spend some time creating snapshots and adding them here for people to see.