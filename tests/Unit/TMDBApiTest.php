<?php

namespace Tests\Unit;

use App\DataSources\TMDBApi;
use GuzzleHttp\Client;
use Tests\TestCase;

class TMDBApiTest extends TestCase
{
    protected $api;

    public function setUp(): void
    {
        parent::setUp();
        $client=new Client();
        $this->api=new TMDBApi($client);
    }

    public function test_getPerson()
    {
        $person=$this->api->getPerson(1);
        $this->assertTrue((int)$person['id']==1);
    }

    public function test_getCredits()
    {
        $id=278;
        $credits=$this->api->getMovieCredits($id);
        $this->assertIsArray($credits);
        $this->assertTrue(count($credits['crew'])>0);
        $this->assertTrue(count($credits['cast'])>0);
    }

    public function test_getDirector()
    {
        $id=278;
        $director=$this->api->getDirector($id);
        $this->assertTrue($director['job']=='Director');
        $this->assertTrue((int)$director['id']>0);
    }

    public function test_getMovie()
    {
        $id=278;
        $movie=$this->api->getMovie($id);
        $this->assertTrue((int)$movie['id']==$id);
    }

    public function test_getTopRatedMoviesList()
    {
        $count=25;
        $movies=$this->api->getTopRatedMoviesList($count);
        $this->assertTrue(count($movies)==$count);
    }
}
