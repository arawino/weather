<h3>Setup </h3>
<ul>
    Clone https://github.com/arawino/weather 

    cd into weather directory 

    Run cp .env.example .env  on command line (to create .env file)

    Once .env is created open it and edit:

    OPEN_WEATHER_TESTING_API_KEY variable with your open weather api_key 

    Run compose install

    Run php artisan key:generate

    Run php artisan serve

    Copy the generate url to your browser (e.g http://127.0.0.1:8000/)



    <h3>To Use CLI Command </h3>

    Run php artisan current:forecast <cityName> 
    e.g php artisan current:forecast london to get London’s current weather

    Unit test
    Run "./vendor/bin/phpunit" on command line
