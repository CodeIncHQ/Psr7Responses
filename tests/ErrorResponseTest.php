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
// Date:     03/05/2018
// Time:     12:38
// Project:  Psr7Responses
//
declare(strict_types=1);
namespace CodeInc\Psr7Responses\Tests;
use CodeInc\Psr7Responses\ErrorResponse;
use CodeInc\Psr7Responses\Tests\Assets\FakeException;


/**
 * Class ErrorResponseTest
 *
 * @uses ErrorResponse
 * @package CodeInc\Psr7Responses\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr7Responses/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr7Responses
 */
class ErrorResponseTest extends AbstractResponseTestCase
{
    /**
     * @throws \ReflectionException
     */
    public function test():void
    {
        $response = new ErrorResponse(new FakeException('Test'));
        self::assertIsResponse($response);
        self::assertInstanceOf(FakeException::class, $response->getError());
        self::assertEquals($response->getError()->getMessage(), 'Test');
        self::assertResponseStatusCode(500, $response);
        self::assertResponseHasBody($response);
    }
}