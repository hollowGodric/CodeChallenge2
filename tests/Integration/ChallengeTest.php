<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'IntegrationTestTrait.php';

use PHPUnit\Framework\TestCase;

class ChallengeTest extends TestCase
{
    use IntegrationTestTrait;

    public function testGetChallenges()
    {
        $response = $this->getClient()->get('/challenges');

        $this->assertEquals(
            [
                [
                    'id' => 1,
                    'title' => 'Bring a shrubbery',
                    'introduction' => 'The shrubbery should look nice and not be too expensive',
                    'points' => 10,
                ],
                [
                    'id' => 2,
                    'title' => 'Endure French Taunting',
                    'introduction' => 'In order to find food an shelter for the knight',
                    'points' => 30,
                ],
                [
                    'id' => 3,
                    'title' => 'Resist the peril at Castle Anthrax',
                    'introduction' => 'It is important to maintain your chastity',
                    'points' => 25,
                ],
                [
                    'id' => 4,
                    'title' => 'Guard Prince Herbert',
                    'introduction' => 'You just stay here and make sure he doesn\'t leave until I come and get him',
                    'points' => 50,
                ],
                [
                    'id' => 5,
                    'title' => 'Burn the witch?',
                    'introduction' => 'If she really is a witch, she\'ll be made of wood.',
                    'points' => 5,
                ],
                [
                    'id' => 6,
                    'title' => 'Cross the Bridge of Death',
                    'introduction' => 'Essentially, you need to answer three questions correctly',
                    'points' => 10,
                ],
                [
                    'id' => 7,
                    'title' => 'Bloody peasant!',
                    'introduction' => 'Argue politics with the rabble.',
                    'points' => 77,
                ],
                [
                    'id' => 8,
                    'title' => 'Find the Holy Grail',
                    'introduction' => 'It is your sacred task.',
                    'points' => 10,
                ],
                [
                    'id' => 9,
                    'title' => 'Defeat the Guardian of the Cave of Caerbannog',
                    'introduction' => 'If necessary, you may use the Holy Hand Grenade of Antioch',
                    'points' => 95,
                ],
                [
                    'id' => 10,
                    'title' => 'The Black Beast of Arrrghhh',
                    'introduction' => 'So far nobody has lived long enough to utter this monster\'s true name',
                    'points' => 100,
                ],
            ],
            json_decode($response->getBody()->getContents(), true));
    }

    public function testGetSingleChallenge()
    {
        $response = $this->getClient()->get('/challenges/3');

        $this->assertEquals(
            [
                'id' => 3,
                'title' => 'Resist the peril at Castle Anthrax',
                'introduction' => 'It is important to maintain your chastity',
                'points' => 25,
            ],
            json_decode($response->getBody()->getContents(), true));
    }
}
