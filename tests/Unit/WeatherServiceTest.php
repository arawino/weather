<?php

namespace Tests\Unit;

use App\Models\Weather;
use App\Services\WeatherProviders\OpenWeather\ForecastTypes\CurrentWeather;
use App\Services\WeatherProviders\OpenWeather\Http\HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    /**
     * @var string
     */
    private string $jsonResponse;

    /**
     * @var MockHandler
     */
    private $clientMock;

    /**
     * @var array
     */
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->headers =['Content-Type' => 'application/json;', 'timeout' => 5 ];
        $this->jsonResponse  = '{"coord":{"lon":0.2845,"lat":50.7687},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"base":"stations","main":{"temp":282.26,"feels_like":280.8,"temp_min":281.48,"temp_max":282.59,"pressure":997,"humidity":94},"visibility":10000,"wind":{"speed":2.68,"deg":77,"gust":4.92},"rain":{"1h":0.42},"clouds":{"all":100},"dt":1621068421,"sys":{"type":3,"id":2037983,"country":"GB","sunrise":1621051793,"sunset":1621107643},"timezone":3600,"id":2650497,"name":"Eastbourne","cod":200}';
        $this->clientMock = new MockHandler([new Response(200, $this->headers, $this->jsonResponse)]);
    }

    /**
     * Simulate http request by send request a request to a dummy url
     * @throws GuzzleException
     */
    public function testSendRequestIsSuccessfulForCurrentForecast()
    {
        $mockClientHandlerStack = HandlerStack::create($this->clientMock);
        $client = new Client(['handler' => $mockClientHandlerStack]);

        $response = $client->request('GET', 'example.com');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody()->getContents());
    }


    /**
     * Test parseResponse is working correctly and returning back an instance of Weather model.
     */
    public function testCurrentRequestForecastResponseDataIsParsedCorrectly()
    {
        $currentForecast = new CurrentWeather(Mockery::mock(HttpClient::class));
        $data = $currentForecast->parseResponse($this->jsonResponse);

        $this->assertInstanceOf(Weather::class, $data);
        $this->assertNotEmpty($data);
        $this->assertEquals('Eastbourne', $data->getCity());
        $this->assertIsObject($data);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
