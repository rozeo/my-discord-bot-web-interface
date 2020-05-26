<?php


namespace App;

use Exception;
use phpDocumentor\Reflection\Types\Resource_;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileStreamedResponse extends StreamedResponse
{

    /**
     * @var string
     */
    private string $filename;

    /**
     * @var int
     */
    private int $chunkSize;

    public function __construct(string $filename, int $chunkSize = 4096, int $status = 200, array $headers = [])
    {
        if (!file_exists($filename) && is_dir($filename)) {
            throw new Exception('Not found file: ' . $filename);
        }

        $this->filename = $filename;
        $this->chunkSize = $chunkSize;

        parent::__construct(function () {
            $this->sendFileContents();
        }, $status, $headers);

        $this->headers->set('Transfer-Encoding', 'chunked');
        $this->headers->set('X-Accel-Buffering', 'no');
    }

    private function sendFileContents()
    {
        $fp = fopen($this->filename, 'rb');
        if (!flock($fp, LOCK_SH)) {
            throw new Exception('Cannot lock set file.');
        }

        ob_start();

        foreach ($this->read($fp) as $chunk) {
            echo $chunk . "\r\n";
            flush();
            ob_flush();
        }

        flock($fp, LOCK_UN);
        fclose($fp);
        ob_end_flush();
    }

    private function read($fp): \Generator
    {
        while(!feof($fp)) {
            yield fread($fp, $this->chunkSize);
        }
    }
}