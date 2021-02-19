<?php

use Laravel\Passport\ClientRepository;
use Laravel\Lumen\Testing\DatabaseTransactions;


class CarbonOffsetScheduleTest extends TestCase
{
    use DatabaseTransactions;

    protected $headers = [];

    //define test cases
    protected $testCases = [
        [
            'input' => ['2021-01-07', '5'],
            'responce_code' => 200,
            'responce' => ["2021-02-07", "2021-03-07", "2021-04-07", "2021-05-07", "2021-06-07"]
        ],
        [
            'input' => ['1998-01-07', '2'],
            'responce_code' => 200,
            'responce' => ["1998-02-07", "1998-03-07"]
        ],
        [
            'input' => ['2020-01-30', '3'],
            'responce_code' => 200,
            'responce' => ["2020-02-29", "2020-03-30", "2020-04-30"]
        ],
        [
            'input' => ['2021-01-10', '0'],
            'responce_code' => 200,
            'responce' => []
        ],
        [
            'input' => ['2031-01-30', '0'],
            'responce_code' => 422,
            'responce' => [
                "subscriptionStartDate"=>["The subscription start date must be a date before or equal to today."]
            ]
        ],
        [
            'input' => ['2020-01-30', '200'],
            'responce_code' => 422,
            'responce' => [
                "scheduleInMonths"=>["The schedule in months must be between 0 and 36."]
            ]
        ],
        [
            'input' => ['', '200'],
            'responce_code' => 422,
            'responce' => [
                "subscriptionStartDate"=>["The subscription start date field is required."]
            ]
        ],
        [
            'input' => ['2020-01-30', ''],
            'responce_code' => 422,
            'responce' => [
                "scheduleInMonths"=>["The schedule in months field is required."]
            ]
        ],
    ];

    /**
     * Setting up the test
     * Get ready the API endpoint to make authorized requests. Create client and oauth token for testing
     */
    public function setUp(): void
    {
        parent::setUp();
        $clientRepository = new ClientRepository();
        $client = $clientRepository->create(null,'Test Case Client', $this->baseUrl);

        try {
            $response = json_decode($this->post('v1/oauth/token', array(
                'grant_type' => 'client_credentials',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'scope' => ' *'))->response->baseResponse->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return;
        }

        $token = $response['access_token'];

        //set header with token created above
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
    }

    /**
     * Testing validation and responces
     *
     * @return void
     */
    public function testInputValidation()
    {
        foreach ($this->testCases as $testCase){
            $this->get('/api/carbon-offset-schedule?subscriptionStartDate='.$testCase['input'][0].'&scheduleInMonths='.$testCase['input'][1].'', $this->headers);
            $this->assertResponseStatus($testCase['responce_code']);
            $this->assertJson(json_encode($testCase['responce']));
        }
    }
}
