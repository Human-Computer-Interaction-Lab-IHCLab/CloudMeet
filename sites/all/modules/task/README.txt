The Task module allows users to create and assign tasks to each other. Users can manage their tasks from the "My account" page.

Just go to "My account" -> Tasks.

## Installation

Download and install the following modules:

- [Task](https://drupal.org/project/task)
- [Entity API](https://drupal.org/project/entity)
- [Entity reference](https://drupal.org/project/entityreference)
- [Ctools](https://drupal.org/project/ctools)
- [Views](https://drupal.org/project/views)

If you use Drush, run the following command:

`$ drush dl task entity entityreference ctools views`

## Configuration

You must assign the following 3 permissions to a user to make Task usable:

- Create tasks
- View own tasks
- Edit own tasks

All users can create and manage task from "My account" -> Tasks.

## Warning

Please understand that is module is still a work in progress.

Also, while this module is in development, there will be no database upgrade support.

