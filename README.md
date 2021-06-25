# php-login-pdo

create database & user
sqlite3 db
  create table users (id integer primary key asc, user text unique, pass text);
  insert into users (user, pass) values ('1234', '1234');

* for SQL Server
$db = new PDO('sqlsrv:server=127.0.0.1; Database = database', 'user', 'password');

Tnks..
