# Summery

* The main endpoint is `api/carbon-offset-schedule` which handles the requests for schedule.
* Lumen Framework has being used for the development and package Passport (`dusterio/lumen-passport`) is used to handle authentication of requests.
* The test cases are defined in `tests/CarbonOffsetScheduleTest.php`
* Test class has a **$testCases** array to define cases for ease and all of them will automatically be executed while running test `vendor/phpunit/phpunit/phpunit`


# Configure

1. In the terminal please run the following commands

`git clone https://github.com/UdyW/carbon-offset-api.git`

`cd carbon-offset-api`

` composer install`

`mv .env.example .env`
 
 2. Change following in the .env file
 
APP_KEY=base64:xnHdP8VbRyfX33KxjtPB1oZbwvT/WYAENdjet7quG28=
 
DB_CONNECTION=sqlite
 
remove all other DB_* values
 
3. In the terminal 

`php artisan passport:client`

This will prompt to enter Client id which can be ignored (press return), then client name which should be entered and redirect url also can be ignored.
Then it will create a Client ID and a Client Secret which should be taken a note of.
Example;

```
Client ID: 2
Client secret: aGCZWXswHCVXJgbW4MmIX69GxCHMdOuDvUMxjYLI
```

4. Then run following in the Terminal

` php -S localhost:8000 -t public`

Please use a deferent port if 8000 already in use

5. Please do the following CURL call. If Postman is used the parameters should go in Body as form-data
Make sure to replace the {clientID} and {client_secret} with the values created above
```php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8000/v1/oauth/token',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('grant_type' => 'client_credentials','client_id' => '{clientID}','client_secret' => '{client_secret}','scope' => ' *'),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
```

This will provide you with a long access_token needed to validate the API calls.

6. Once this is done request can be sent to the endpoint /api/carbon-offset-schedule

```php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8000/api/carbon-offset-schedule?subscriptionStartDate=&scheduleInMonths=20',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'authorization: Bearer {access_token}'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

```
make sure to replace {access_token} with the one created above

Run tests
` vendor/phpunit/phpunit/phpunit`

