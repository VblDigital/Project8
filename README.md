#ToDoList

ToDo & Co' company has developed an application which is a tool to manage all the common daily tasks.

As a new developer, we have to :
* correct :
    * link one task to an user. All non-linked tasks have to be associated to an user called anonymous
    * a role has to be associated to all users
* implement new functionalities : 
    * users CRUD access has to be limited to a user with ROLE_ADMIN
    * tests have to be implemented
     
##How to install application locally
1. Clone or download the project :
```
cd TodoList/
git clone https://github.com/vbopenclass/Project8.git
```

2. Add an .env file with your credentials for database access

3. Use Composer to install all needed dependencies
```
composer install
```

4. Create the database, the tables and add the data with DataFixtures : 
```
php bin/console do:da:cr
php bin/console do:sc:up --force
php bin/console do:fi:lo --append
```

5. Launch the server :
```
php bin/console se:ru
```

This application has been developped with :

* Symfony 3.4
* WampServer - Version 3.2.0 - 64bit
* PhpStorm - 2019.1.1
* Codacy Badge [![Codacy Badge](https://api.codacy.com/project/badge/Grade/c140af8c81464f5288d2c0d09ab42032)](https://www.codacy.com/manual/vbopenclass/Project8?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=vbopenclass/Project8&amp;utm_campaign=Badge_Grade)

Valérie Bleser - vbopenclass