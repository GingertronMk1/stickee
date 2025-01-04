# Technical Test for Stickee

### Description

This is a platform built using Laravel, Tailwind, Typescript, and Inertia for the completion of a technical task given to me by Stickee.

The objective of this platform is to tell a widget company, Wally's Widgets, what combination of packs to send out for a given order size.
The rules for these combinations are as follows:

1. Only whole packs can be sent. Packs cannot be broken open.
2. Within the constraints of Rule 1 above, send out no more widgets than necessary to fulfil
   the order.
3. Within the constraints of Rules 1 & 2 above, send out as few packs as possible to fulfil each
   order.

The initial set of pack sizes is

- 250 widgets
- 500 widgets
- 1,000 widgets
- 2,000 widgets
- 5,000 widgets

### Rationales

##### Dependency Injection

I abstracted the actual service out such that I could typehint an interface in multiple scenarios and Laravel will automatically insert the correct class.

##### "Config Injection"

Based on the work I've done in Symfony in the past I know that it is possible to pass in configurations to services.
My knowledge of Laravel does not tell me if that is possible within the platform, hence my implementation of a pseudo-injection.
Within the `WidgetCounter` concrete class there is an optional constructor parameter, `$packSizes`.
If this parameter is not set the class calls from the app config.
I took this approach for greater ease of testing, and the ability to quickly change the available pack sizes.

##### Database Caching

While this is not an issue with the pack sizes in the initial scope of the task, it is possible that with a wider variety of pack sizes and order sizes the computation could become unwieldy.
In order to combat that I have decided to store the result of every computation done, keyed by the available pack sizes and the size of the order.
Now if an end user requests a combination of packs that the system has seen before, and the available pack sizes has not changed, the system can simply get that value from the database rather than recompute it.

### Installation and running

Run the following in a terminal window (assuming a Mac or other Unix-based system):

```shell
composer install
./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh
```

Now access `localhost`, and you should be greeted with a simple screen asking for a number of widgets.
Enter a number, say `250`, click "Calculate", and the page will reload with the combination of packs, as well as a small readout stating whether or not the value was retrieved from the database.

In addition to the web interface you can enter into a terminal `./vendor/bin/sail artisan app:widget-counter-command {widgets}`, where `{widgets}` is the desired number of widgets, and you will be given a table with the pack sizes, as with the web interface.
