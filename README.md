Centralny Rejestr Rzeczy Znalezionych



The web app allowing to register and enter the data published in the public information bulleting regarding the lost and found things.



Allowing to download a structurized json to upload the data to dane.gov.pl



TYPE OF PROJECT: sql + php + js + bootstrap + dom



Challange submited on Hacknation 2025 with score 3.35/5



This is a MIT license product - test challange project.



Deploy requirements: 

In phpMyAdmin:

1. create a mySQL database namend main\_db (accroding to db.php)
2. import the data brz\_app\_script.sql

3\. Create user and grant privilages by executing queries:





CREATE USER 'sa'@'localhost' IDENTIFIED BY 'KochamMCBardzo';

GRANT ALL PRIVILEGES ON main\_db.\* TO 'sa'@'localhost';



In Apache, copy the php files to the folder like brz\_app

open website http://localhost/brz_app



TO DO before production use:

Filters,

Search modal form,

Auto generating docoments neccessary on polish found things act - ustawa o rzecach znalezionych, like: protokół przyjęcia rzeczy, protokół wydania rzeczy, poświadczenie przyjęcia rzeczy.



Można utworzyć nowe konto, zalogować się a następnie dodawac do rejestru rzeczy, albo użyć credential testowych.

Link do aplikacji http://znalezione.atwebpages.com/



Login i hasło testowe:

test

test



Linki do api testowego:

http://znalezione.atwebpages.com/api\_export.php?teryt=0201000          

http://znalezione.atwebpages.com/api\_export.php?teryt=0201000\&rok=2025



For more info you can reach me on: 

https://www.linkedin.com/in/grzegorz-%C5%82aba-7388671b1/

my website: grzes.blu24.pl

or by creating an issue on github

