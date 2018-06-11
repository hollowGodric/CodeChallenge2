<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'IntegrationTestTrait.php';

use PHPUnit\Framework\TestCase;

class ScoreTest extends TestCase
{
    use IntegrationTestTrait;

    public function testPostScore()
    {
        $response = $this->getClient()->post('/score?challenge_id=1', ['headers' => ['X_AUTH_TOKEN' => 'key']]);

        $this->assertEquals(['message' => '10 points added.'], json_decode($response->getBody()->getContents(), true));
    }

    public function invalidHeadersProvider()
    {
        return [
            [
                [] // empty
            ],
            [
                ['headers' => ['X_AUTH_TOKEN_WRONG' => 'key']]
            ],
        ];
    }

    /**
     * @param $options
     * @dataProvider invalidHeadersProvider
     * @expectedException \GuzzleHttp\Exception\ClientException
     * @expectedExceptionCode 400
     */
    public function testPostScoreMissingToken($options)
    {
        $this->getClient()->post('/score?challenge_id=1', $options);
    }

    public function invalidArgumentsProvider()
    {
        return [
            [
                [], // empty is invalid
            ],
            [
                ['challenge' => 8]
            ]

        ];
    }

    /**
     * @param $arguments
     * @dataProvider invalidArgumentsProvider
     * @expectedException \GuzzleHttp\Exception\ClientException
     * @expectedExceptionCode 400
     */
    public function testPostScoreMissingChallengeId($arguments)
    {
        $this->getClient()->post('/score?' . \GuzzleHttp\Psr7\build_query($arguments), ['headers' => ['X_AUTH_TOKEN' => 'key']]);
    }

    /**
     * @expectedException \GuzzleHttp\Exception\ClientException
     * @expectedExceptionCode 404
     */
    public function testPostScoreInvalidChallengeId()
    {
        $this->getClient()->post('/score?challenge_id=12', ['headers' => ['X_AUTH_TOKEN' => 'key']]);
    }
}
