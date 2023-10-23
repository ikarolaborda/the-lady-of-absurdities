# The Lady of Absurdities

This application is a stack Overflow Clone. 
It was created as a part of the Symfony 5: The Fast Track course on SymfonyCasts.com.
It was also updated to symfony 6.* 

## Setup
#### This project uses PHP 8.2 and Symfony 6.*, and relies upon Docker for an entire dev environment setup.
To get it working, follow these steps:

**Do the Initial Docker Build for the application**

Make sure you have [Docker](https://docs.docker.com/get-docker/) installed
and then run:

```
# This will generate a self-signed SSL certificate for your local environment. Run only once.
make generate-ssl
# This will run a sequence of build-necessary commands. Run only once.
make setup
#If you have already run the above commands, you can run the following command to start the application
make dup
```

These commands runs a set of instructions in the `Makefile` to build your project,
it's kind of an automated way to run a bunch of commands. You can see what it's
doing by opening the `Makefile` and looking at the `build` command.

If you do *not* want to use Docker, just make sure to start your own
database server and update the `DATABASE_URL` environment variable in
`.env` or `.env.local` before running the commands above.

**Start the Symfony web server**

You can use Nginx or Apache, but Symfony's local web server
works even better.

To install the Symfony local web server, follow
"Downloading the Symfony client" instructions found
here: https://symfony.com/download - you only need to do this
once on your system.

Then, to start the web server, open a terminal, move into the
project, and run:

```
symfony serve
```

(If this is your first time using this command, you may see an
error that you need to run `symfony server:ca:install` first).

[Leia em português](README_PT.md)

