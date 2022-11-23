# "Works Diary" Backend API

## Project Installation

Install ```composer```.
```
composer install
```

Copy ```.env.example``` file to ```.env``` file and set database information.
```
cp .env.example .env
```

Generate key in ```.env``` file.
```
php artisan key:generate
```

Link ```storage```.
```
php artisan storage:link
```

Migrate database migrations with seeds.
```
php artisan migrate --seed
```

Install ```npm``` (if necessary).
```
npm install
```
