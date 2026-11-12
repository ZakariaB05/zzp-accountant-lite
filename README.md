# ZZP Accountant Lite

Een webapplicatie voor Nederlandse freelancers (ZZP'ers) om gewerkte shifts, zakelijke kilometers en onkosten bij te houden. De app geeft direct een schatting van de nettowinst en de BTW-reservering voor de kwartaalaangifte.

Gebouwd als portfolioproject tijdens mijn MBO Niveau 4 opleiding Software Development.

## Screenshots

![Dashboard](docs/dashboard.png)

## Functionaliteiten

- **Dashboard** met samenvattingskaarten: totale inkomsten, gewerkte uren, zakelijke kilometers, onkosten, geschatte nettowinst en BTW-reservering voor het lopende kwartaal. Daaronder een tabel met recente shifts en ritten.
- **Shift tracker**: opdrachtgever, datum, uren, uurtarief en BTW-tarief (21%, 9% of BTW-vrij). Bedragen exclusief en inclusief BTW worden automatisch berekend.
- **Kilometerregistratie**: datum, van, naar, kilometers en voertuig. De fiscale aftrekpost (€ 0,23 per km) wordt automatisch berekend.
- **Onkostenregistratie**: titel, categorie (Apparatuur, Reiskosten, Software), bedrag excl. BTW en BTW-bedrag.
- **Gebruikersaccounts** (registreren en inloggen). Elke gebruiker ziet alleen de eigen gegevens.
- **Profielfoto uploaden**, getoond in de sidebar.

## Berekeningen

De berekeningen staan in de helper `app/Helpers/TaxCalculator.php`:

| Berekening | Formule |
|---|---|
| Kilometeraftrek | kilometers × € 0,23 |
| Nettowinst | omzet − (onkosten + kilometeraftrek) |
| BTW-reservering | ontvangen BTW − betaalde BTW |

> **Let op:** dit zijn schattingen en geen belastingadvies. De app berekent geen volledige inkomstenbelasting (zoals zelfstandigenaftrek of schijventarieven).

## Technieken

- Laravel 11 (PHP 8.3), MVC-structuur
- Eloquent ORM met relaties en foreign keys
- Form Requests voor validatie, met Nederlandse foutmeldingen
- Blade-templates met herbruikbare componenten
- Tailwind CSS
- Laravel Breeze voor authenticatie
- PHPUnit tests
- GitHub Actions (CI) die bij elke push `php artisan test` draait
- Docker Compose (PHP-FPM, nginx, MariaDB)

## Projectstructuur

```
app/
  Helpers/TaxCalculator.php        berekeningen
  Http/Controllers/                Dashboard, Shift, Trip, Expense, ProfilePhoto
  Http/Requests/                   validatie per formulier
  Models/                          User, Shift, Trip, Expense
database/migrations/               shifts, trips, expenses (met foreign keys)
resources/views/                   Blade-views en componenten
tests/                             unit- en feature-tests
```

## Installatie (lokaal)

Vereisten: PHP 8.3 of hoger, Composer en Node.js.

```bash
git clone https://github.com/ZakariaB05/zzp-accountant-lite.git
cd zzp-accountant-lite

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link

npm install
npm run build

php artisan serve
```

Open daarna http://127.0.0.1:8000 en maak een account aan.

## Installatie met Docker

```bash
cp .env.example .env
```

Zet in `.env` deze databasegegevens:

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=zzp_accountant
DB_USERNAME=zzp
DB_PASSWORD=secret
```

```bash
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan storage:link

npm install
npm run build
```

Open daarna http://localhost:8080.

## Tests

```bash
php artisan test
```

De tests controleren onder andere de berekening van € 0,23 per kilometer, de nettowinst en BTW-reservering, en of het dashboard alleen toegankelijk is voor ingelogde gebruikers.

## Mogelijke verbeteringen

- Filteren en zoeken op periode (kwartaal, jaar)
- Exporteren naar CSV of PDF voor de boekhouder
- Feature-tests voor de CRUD-controllers
- Zelfstandigenaftrek en belastingschijven meenemen in de schatting
- Facturen genereren op basis van shifts

## Auteur

Zakaria — [GitHub](https://github.com/ZakariaB05)