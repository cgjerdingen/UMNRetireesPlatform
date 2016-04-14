# UMNRetireesPlatform

## Setup
### Dependencies
* PHP 5.6+
  * Linux: Install from your package manager (e.g. `sudo apt-get install php-cli`)
  * Mac OS X: Install from [Homebrew](http://brew.sh) with [homebrew-php](https://github.com/Homebrew/homebrew-php) (`brew install php56`) (recommended) or through [a package](http://php-osx.liip.ch/) (easier)
* MySQL 5.5+
  * Linux: Install from your package manager (e.g. `sudo apt-get install mysql-server`)
  * Mac OS X: Install from [Homebrew](http://brew.sh) (`brew install mysql`) (recommended) or through [a package](https://dev.mysql.com/downloads/mysql/) (easier)
* [Composer](http://getcomposer.org), for installing dependencies

### Fetching the Code
1. Run `git clone https://github.com/cgjerdingen/UMNRetireesPlatform.git && cd UMNRetireesPlatform`

### Installing
1. Run `php app/check.php` and resolve any errors before doing ANYTHING else.
2. Run `php [path to composer.phar] install` to fetch dependencies. Composer will also prompt you for configuration values, such as MySQL database name, password, etc.
3. Run `php app/console doctrine:database:create` if you have not already created the database for the application.
4. Run `php app/console doctrine:schema:create` to create the table structure for the application.
5. Run `php app/console server:run` to run the application. The application should now be running on [http://localhost:8000](http://localhost:8000)

### Updating
1. Run `git pull` to fetch the latest changes to the application. If you've made changes to the application, you'll either want to stash them or commit them and use `git pull --rebase`.
2. Run `php composer.phar install`
3. Run `php app/console cache:clear`
4. Run `php app/console server:run` to run the application. The application should now be running on [http://localhost:8000](http://localhost:8000)

## Commands

The following options are UMRA-specific commands that can be run as `php app/console [command]`

* `umra:member:activate` - Activate a member
* `umra:member:change-password` - Change the password of a member.
* `umra:member:create` - Create an UMRA member.
* `umra:member:deactivate` - Deactivate a member
* `umra:member:demote` - Demote a member by removing a role
* `umra:member:promote` - Promotes a member by adding a role

### Roles

These roles can be used in conjunction with `umra:member:demote` and `umra:member:promote`.

* `ROLE_USER` - standard user. everyone user should have this role, as it grants a standard set of permissions.
* `ROLE_ADMIN` - admin user. has additional permissions to manage users, transactions, and almost everything.
* `ROLE_SUPER_ADMIN` - super admin. has all the permissions of `ROLE_ADMIN`.


#### Important Paths

* `app/Resources/views` - Contains application-level views shared by most of the application. `base.html.twig` is the main layout.

* `src/UMRA/Bundle/MemberBundle` - Contains all of the source code for the application.

* `src/UMRA/Bundle/MemberBundle/Resources/views` - Partial views for all the actions in the site. Almost all extend from the `base.html.twig` template.

#### Helpful Links

* [Symfony 2.6 Documentation](https://symfony.com/doc/2.6/index.html)
* [FOSUserBundle Documentation](https://github.com/FriendsOfSymfony/FOSUserBundle/tree/master/Resources/doc) - The application's user model and such are provided through this bundle.
* [LexikFormFilterBundle Documentation](https://github.com/lexik/LexikFormFilterBundle) - The application's record filtering forms are built using this bundle.
