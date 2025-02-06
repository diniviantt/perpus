<p align="center"><a href="https://orzproject.my.id" target="_blank"><img src="https://cdn.jsdelivr.net/gh/orz14/orzcode@main/img/orz-stack_laravel.webp" width="400" alt="ORZ Stack Logo"></a></p>

## About ORZ Stack

ORZ Stack is the skeleton application for the Laravel starter kit project. It comes equipped with a system authentication that includes both basic authentication and socialite authentication. Additionally, ORZ Stack includes several built-in packages that I frequently use, such as Tailwind CSS, Livewire, Eloquent Sluggable, and many more. It offers a feature-rich boilerplate to kickstart your project and expedite your development process. Now, you're ready to create your awesome project.

## System Requirements

-   PHP >= 8.1
-   Composer
-   NodeJS & NPM/PNPM
-   MySQL

## Installation

-   Create a new ORZ Stack project via Composer's create-project command:

```bash
composer create-project orz14/orz-stack app-name
```

-   Once the project has been created, migrate the database:

```bash
cd app-name
php artisan migrate
```

-   Finally, start Laravel's local development server using Laravel Artisan's serve command:

```bash
php artisan serve
```

-   Open the browser and go to http://localhost:8000 or http://app-name.test

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

<p align="center">Created with 💜 by <a href="https://orzproject.my.id" target="_blank">ORZCODE</a></p>
