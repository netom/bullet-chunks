<?php

class ChunkedTest extends PHPUnit_Framework_TestCase {

    private $_testContent = [
        "The", " ", "quick", " brown", " fox ", "jumps", " over ", "the ",
        "lazy ", "dog."
    ];

    public function testNonBufferedChunkedEncoding() {
        $c = new Bullet\Response\Chunked($this->_testContent);
        $c->chunkSize = 0;
        ob_start();
        $c->send();
        $output = ob_get_clean();

        $shouldBe = '';
        foreach ($this->_testContent as $word) {
            $shouldBe .= sprintf("%x\r\n%s\r\n", strlen($word), $word);
        }
        $shouldBe .= "0\r\n\r\n";

        $this->assertEquals($shouldBe, $output);
    }

    public function testBufferedChunkedEncoding() {
        $c = new Bullet\Response\Chunked($this->_testContent);
        $c->chunkSize = 10;
        ob_start();
        $c->send();
        $output = ob_get_clean();

        $shouldBe = '';
        foreach (str_split(implode('', $this->_testContent), 10) as $word) {
            $shouldBe .= sprintf("%x\r\n%s\r\n", strlen($word), $word);
        }
        $shouldBe .= "0\r\n\r\n";

        $this->assertEquals($shouldBe, $output);
    }

}
