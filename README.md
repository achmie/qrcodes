# QR-codes (English)
QR-codes is an example application that uses QR codes. Its operation
is to simulate the work of the library. Users with the given QR code
can log in and borrow books that are also marked with 
relevant QR codes.

## Database
In the file [sql/qrcodes_db.sql](sql/qrcodes_db.sql) there are commands
creating an example database. It contains several books and a few
users.

## Web page
The website has been developed based on HTML, CSS and PHP. Application
is in the file [www/index.php](www/index.php), and complete
style sheet can be found at [www/qrcodes.css](www/qrcodes.css).

To run the application, you must first set up access
into a database that is exactly as structured as it was 
specified in the file [sql/qrcodes_db.sql](sql/qrcodes_db.sql). Access 
to databases define by entering the username, password to the database 
and name of database:
```php
$dbuser = '';
$dbpass = '';
$dbname = '';
```

After defining these options, the application can be launched on the 
WWW server that supports PHP.

## License
[MIT](LICENSE)


# QR-codes (Polski)
QR-codes jest przykładową aplikacją wykorzystującą kody QR. Jej działanie 
polega na symulacji pracy biblioteki. Użytkownicy o podanym QR kodzie 
mogą się zalogować i wyporzyczać książki, które również oznaczone są 
odpowiednimi QR kodami.

## Baza danych
W pliku [sql/qrcodes_db.sql](sql/qrcodes_db.sql) znajduje się komendy 
tworzące przykładową bazę danych. Zawiera ona kilka książek i kilku 
użytkowników.

## Strona WWW
Strona WWW została opracowana w oparciu o HTML, CSS i PHP. Aplikacja 
webowa znajduje się w pliku [www/index.php](www/index.php), a kompletny 
arkusz stylu można znaleźć w [www/qrcodes.css](www/qrcodes.css).

Aby uruchomić aplikację należy w pierwszej kolejności ustawić dostęp 
do bazy danych, która ma dokładnie taką strukturę, jak to zostało 
określone w pliku [sql/qrcodes_db.sql](sql/qrcodes_db.sql). Dostęp do 
bazy definiujemy podając nazwę użytkownika, hasło do bazy oraz nazwę 
bazy:
```php
$dbuser = '';
$dbpass = '';
$dbname = '';
```

Po zdefiniowaniu tych opcji aplikacja może zostać uruchomiona w serwisie 
WWW obsługującym język PHP.

## Generowanie kodów QR dla aplikacji
Kody dla książek mają postać:
```
http://moja.domena.pl/index.php?action=book&id=<numer>
```
Kody dla użytkowników są natomiast postaci:
```
http://moja.domena.pl/index.php?action=login&id=<numer>
```
Poniżej przykładowe kody użyte w aplikacji uruchomionej na stronie
[http://qrcode.cmmsigma.eu](http://qrcode.cmmsigma.eu):

1. ``http://qrcode.cmmsigma.eu/index.php?action=book&id=1``
<img src="img/b01.png" width="200" height="200"/>

2. ``http://qrcode.cmmsigma.eu/index.php?action=login&id=1``
<img src="img/u01.png" width="200" height="200"/>

## Licencja
[MIT](LICENSE)
