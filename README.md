# Recepten Applicatie // Fullstack Framework
Een browser-applicatie waarmee gebruikers hun recepten kunnen beheren en filteren op basis van de keuken waar ze vandaan komen.

Gebouwd met een zelfgebouwd MVC fullstack framework, gebruikmakend van Twig Templates en RedBeanPHP ORM.

## Functionaliteiten
- __Gebruikersauthenticatie__
  - Registratie en inloggen

- __Receptenbeheer__
  - Alle recepten bekijken
  - Nieuwe recepten toevoegen
  - Bestaande recepten bewerken

- __Keukenbeheer__
  - Alle beschikbare keukens bekijken
  - Nieuwe keukentypes toevoegen met beschrijvingen
  - Keukeninformatie bewerken
  - Recepten bekijken per keuken

## Technische Stack
- __Backend Framework__: Aangepast PHP MVC Framework
- __Template Engine__: Twig
- __Database ORM__: RedBeanPHP
- __Database__: MySQL

## Installatie
1. Kloon deze repository
2. Configureer je webserver (Apache) om naar de `public` map te wijzen
3. Installeer dependencies:
   ```
   composer install
   ```
4. Stel de MySQL database in:
   - Maak een database aan genaamd 'fullstack_framework'
   - Configureer database inloggegevens in `BaseController.php`:
     ```php
     R::setup('mysql:host=localhost;dbname=fullstack_framework', 'bit_academy', 'bit_academy');
     ```
5. Vul de database met voorbeelddata:
    ```
    php seeder.php
    ```

## Ontwikkelomgeving Opzetten
1. Configureer je virtual host om naar de `public` map te wijzen
2. Het `.htaccess` bestand in de public map regelt de URL herschrijving

## Gebruik
1. Start je webserver (zoals apache)
2. Open de applicatie via je geconfigureerde domein
3. Standaard testgebruiker inloggegevens:
    - Gebruikersnaam: test
    - Wachtwoord: test


## Bijdragen
Voel je vrij om problemen te melden en pull requests in te dienen.