# GFP TK App

## Running locally
> **_NOTE_**: this application uses sails so docker is required.

1. Install composer via docker for us to run `sails`, also make a copy of `.env.local` and generate the required key

```
docker run --rm --interactive --tty -v $(pwd):/app composer install && cp .env.example .env.local
```

2. Run sails and access container shell to generate environment key

```
> ./vendor/bin/sail up -d && ./vendor/bin/sail shell
> php artisan key:generate
```

> There are times that you have to clean the application cache run `php artisan cache:clear`

3. Supply the `GITHUB_PERSONAL_TOKEN` generated from github

```
GITHUB_PERSONAL_TOKEN=<github_token_here>
```
