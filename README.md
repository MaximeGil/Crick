# Crick!

A powerful backend for the Watson time tracker. 

A [Silex] (http://silex.sensiolabs.org/) application with :

* [Negotiation](https://github.com/willdurand/Negotiation)
* [StackNegotiation](https://github.com/willdurand/StackNegotiation)
* [Stack](http://stackphp.com)
* [NegotiationServiceProvider] (https://github.com/K-Phoen/NegotiationServiceProvider)
* [Twig] (http://twig.sensiolabs.org/)
* [UUID] (http://github.com/ramsey/uuid)
* [Pomm] (http://www.pomm-project.org/)

# About

## [Watson](https://github.com/TailorDev/Watson)

> Watson is here to help you monitoring your time. You want to know how much time you are spending on your projects? You want to generate a nice report for your client? Watson is here for you.

>Tell Watson when you start working on a task with the start command. Then, when you are done with this task, stop the timer with the stop command. This will create what we call a frame. That's pretty much everything you need to know to start using Watson.
Each frame consists of the name of a project and some tags. Your tags can be shared across projects and can be used to generate detailed reports.

>Watson stores everything on your computer, but you can go wild and use artich.io to store your sessions remotely and share it with your colleagues.

[For more informations...](https://github.com/TailorDev/Watson)

# Installation

## Composer

To install dependencies, you have to use [Composer] (http://getcomposer.org)

> composer install

## Postgresql

Crick uses postgresql, you have to install it and use crick's sql file here:

> sources/sql/db.sql

## Pomm

If you update your database, please type this command in your terminal for create a new model

> php vendor/bin/pomm.php pomm:generate:schema-all -d db -a 'Db' --psr4 db public


____
