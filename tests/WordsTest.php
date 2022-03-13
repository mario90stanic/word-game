<?php declare(strict_types=1);

use App\Core\App;
use App\Models\Word;
use PHPUnit\Framework\TestCase;

final class WordsTest extends TestCase
{
    /**
     * @test
     * @dataProvider words
     * @throws Exception
     */
    public function checkPointsCount($word, $points)
    {
        $app = new App;

        $app::bind('config', [
            'palindrome_points' => 3,
            'almost_palindrome_points' => 2,
        ]);

        $app::bind('database', []);

        $wordObj = new Word($app);
        $calculatedPoints = $this->callMethod($wordObj, 'calculatePoints', [$word]);

        $this->assertEquals($points, $calculatedPoints['total']);
    }

    public function words()
    {
        return [
           ['test', 5], // almost palindrome
           ['wow', 5], // palindrome
           ['coin', 4], // regular
           ['book', 3], // regular
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