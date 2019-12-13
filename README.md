# Loat-1.0
 location des voitures

# Pre-réquis
1. download and installer composer
2. download and installer LATEST version of xampp !!IMPORTANT!! 
3. go to c://xampp/htdocs/ and run the command line in the terminal

```
$ git clone https://github.com/abdoul-aziz/Loat-1.0.git
```

4. go to c://xampp/htdocs/loat-1.0/ and run the command line in the terminal

```
$ cp .env.example .env
```

5. open the browser and enter the url: localhost/phpmyadmin 
    create a database with the name:  loat
 
6. open the .env file, change the 3 lines below to match with these. 
-DB_DATABASE=loat
-DB_USERNAME=root
-DB_PASSWORD=

7. run the command line 
```
$ composer install
```
```
$ php artisan migrate
```

```
$ php -S localhost:8000 -t public
```
8. go to browser and run the url: localhost:8000

9. enjoy if anything just update the read me so that we can continue update the app. 
