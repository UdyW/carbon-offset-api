# Configure
` composer install`

` php -S localhost:8000 -t public`

`php artisan passport:client`

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
  CURLOPT_POSTFIELDS => array('grant_type' => 'client_credentials','client_id' => '1','client_secret' => 'M9mw6mCd2TbyYOzhnsa8LRPYn1iozIYbGHb67vCv','scope' => ' *'),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
```

` vendor/phpunit/phpunit/phpunit`
