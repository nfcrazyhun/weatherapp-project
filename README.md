# Weather App project
## About this app
It is a Weather Forecast App made in Laravel,
together with Tailwind CSS, Alpine.js, Chart.js
Utilize OpenWeatherMap - Weather API for weather data

**This application made for learning purpose.**

You can expect functionality like:
- search cities
- show/hide help for city search
- current weather in the city
- weather forecast for the next 8 days
- temperate, rain, wind visualized on a line graph for the next 48 hours
- toggle forecast for compact view

## Installation guide
1. Open a terminal
2. Clone this repository
```
git clone https://github.com/nfcrazyhun/weatherapp-project.git
```
3. cd into it
4. Copy then rename .env.example to .env
```
cp .env.example .env
```
5. Install dependencies
```
composer install
```
6. (Optional) Install npm packages
```
npm install
```
7. (Optional) Build your assets
```
npm run dev
```
8. Generate application key
```
php artisan key:generate
```

9. (Optional) Register your personal API key, **if the provided one does not work.**
- Signup: https://home.openweathermap.org/users/sign_in
- update the 'OPENWEATHER_API_KEY=' in the .env file

## Note
The project was made with the following software versions:
- PHP 7.4.18
- Laravel Framework 8.52.0
- Tailwind CSS 2.2.7
- Alpine.js 3.2.4
- Chart.js 2.9.4

## Screenshots
![weather-app-1](https://user-images.githubusercontent.com/47859399/130794544-2897471f-bf17-4299-952c-0bd6b10bcb80.JPG)
![weather-app-2](https://user-images.githubusercontent.com/47859399/130794556-9d828efc-f7cb-4c13-b1fa-bb6c35fe4d31.JPG)
