<?php

class ChunkedTest extends PHPUnit_Framework_TestCase {

    private $_testContent = [
        "The", " ", "quick", " brown", " fox ", "jumps", " over ", "the ",
        "lazy ", "dog."
    ];

    private function _runTestBulletApp($chunkSize) {
        $testobj = $this;

        $app = new Bullet\App();

        $app->path('/test', function($request) use ($chunkSize, $testobj) {
            $c = new Bullet\Response\Chunked($testobj->_testContent);
            $c->chunkSize = $chunkSize;
            return $c;
        });

        $response = $app->run('GET', '/test');

        $this->assertInstanceOf('Bullet\\Response\\Chunked', $response);

        ob_start();
        $response->send();
        $output = ob_get_clean();

        return $output;
    }

    public function testNonBufferedChunkedEncoding() {
        $output = $this->_runTestBulletApp(0);

        $shouldBe = '';
        foreach ($this->_testContent as $word) {
            $shouldBe .= sprintf("%x\r\n%s\r\n", strlen($word), $word);
        }
        $shouldBe .= "0\r\n\r\n";

        $this->assertEquals($shouldBe, $output);
    }

    public function testBufferedChunkedEncoding() {
        $CHUNKSIZE = 10;

        $output = $this->_runTestBulletApp($CHUNKSIZE);

        $shouldBe = '';
        foreach (str_split(implode('', $this->_testContent), $CHUNKSIZE) as $word) {
            $shouldBe .= sprintf("%x\r\n%s\r\n", strlen($word), $word);
        }
        $shouldBe .= "0\r\n\r\n";

        $this->assertEquals($shouldBe, $output);
    }

}
