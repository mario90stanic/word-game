<?php declare(strict_types=1);

use App\Models\Word;
use PHPUnit\Framework\TestCase;

final class WordsTest extends TestCase
{
    /**
     * @test
     * @dataProvider words
     */
    public function checkPointsCount($word, $points)
    {
        $config = [
            'palindrome_points' => 3,
            'almost_palindrome_points' => 2,
        ];


        $wordObj = new Word($config, null, $word);
        $calculatedPoints = $this->callMethod($wordObj, 'calculatePoints');

        $this->assertEquals($points, $calculatedPoints['total']);
    }

    public function words()
    {
        return [
           ['test', 5],
           ['wow', 5],
           ['coin', 4],
           ['book', 3],
        ];
    }

    /**
     * @param $object
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    private function callMethod($object, string $method , array $parameters = [])
    {
        try {
            $className = get_class($object);
            $reflection = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }

        $method = $reflection->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}