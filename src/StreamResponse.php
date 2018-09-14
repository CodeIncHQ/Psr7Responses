<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE                                               |
// +---------------------------------------------------------------------+
// | Copyright (c) 2017 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material  is strictly forbidden unless prior   |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     23/02/2018
// Time:     19:15
// Project:  Psr7Responses
//
declare(strict_types = 1);
namespace CodeInc\Psr7Responses;
use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\StreamInterface;


/**
 * Class StreamResponse
 *
 * @package CodeInc\Psr7Responses
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr7Responses/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr7Responses
 */
class StreamResponse extends Response
{
    /**
     * @var StreamInterface
     */
    private $stream;

    /**
     * @var null|string
     */
    private $charset;

    /**
     * @var int|null
     */
    private $contentLength;

    /**
     * @var null|string
     */
    private $fileName;

    /**
     * @var bool
     */
    private $asAttachment;

    /**
     * StreamResponse constructor.
     *
     * @uses stream_for()
     * @param resource|string|null|int|float|bool|StreamInterface|callable $dataSource
     * @param null|string $contentType
     * @param int|null $contentLength
     * @param null|string $fileName
     * @param bool $asAttachment
     * @param int $status
     * @param array $headers
     * @param string $version
     * @param null|string $reason
     */
	public function __construct($dataSource, ?string $contentType = null, ?int $contentLength = null,
		?string $fileName = null, bool $asAttachment = false, int $status = 200, array $headers = [],
		string $version = '1.1', ?string $reason = null)
	{
		$this->stream = stream_for($dataSource);
        $this->charset = $contentType;
        $this->contentLength = $contentLength;
        $this->fileName = $fileName;
        $this->asAttachment = $asAttachment;

		// adding headers
		if ($contentType) {
			$headers["Content-Type"] = $contentType;
		}
		$headers["Content-Disposition"] = $asAttachment ? "attachment" : "inline";
		if ($fileName) {
			$headers["Content-Disposition"] .= sprintf("; filename=\"%s\"", $fileName);
		}
		if ($contentLength !== null || ($contentLength = $this->stream->getSize()) !== null) {
			$headers["Content-Length"] = $contentLength;
		}

		parent::__construct($status, $headers, $this->stream, $version, $reason);
	}

    /**
     * Returns the resource wrapped into a stream.
     *
     * @return StreamInterface
     */
    public function getStream():StreamInterface
    {
        return $this->stream;
    }

    /**
     * Returns the mime type if set or null.
     *
     * @return null|string
     */
    public function getCharset():?string
    {
        return $this->charset;
    }

    /**
     * Returns the content length if set or null.
     *
     * @return int|null
     */
    public function getContentLength():?int
    {
        return $this->contentLength;
    }

    /**
     * Returns the file name if set or null.
     *
     * @return null|string
     */
    public function getFileName():?string
    {
        return $this->fileName;
    }

    /**
     * Verify if the response must be downloaded.
     *
     * @return bool
     */
    public function isAsAttachment():bool
    {
        return $this->asAttachment;
    }
}