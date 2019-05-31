<?php

/** @license
 *  Copyright 2009-2011 Rafael Gutierrez Martinez
 *  Copyright 2012-2013 Welma WEB MKT LABS, S.L.
 *  Copyright 2014-2016 Where Ideas Simply Come True, S.L.
 *  Copyright 2017 nabu-3 Group
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

namespace nabu\csv\infrastructure;

use PHPUnit\Framework\Error\Error;

use PHPUnit\Framework\TestCase;

use nabu\infrastructure\reader\interfaces\INabuDataListReader;
use nabu\infrastructure\reader\interfaces\INabuDataListFileReader;

/**
 * Tests for class @see {CNabuCSVReader }.
 * @author Rafael Gutierrez <rgutierrez@nabu-3.com>
 * @since 3.0.0
 * @version 3.0.0
 * @package \nabu\csv\infrastructure
 */
class CNabuCSVReaderTest extends TestCase
{
    /**
     * @test __construct
     * @test getValidMIMETypes
     * @test customFileValidation
     * @test openSourceFile
     * @test closeSourceFile
     * @test createDataListInstance
     * @test getSourceDataAsArray
     * @test checkBeforeParse
     */
    public function testConstruct()
    {
        $reader = new CNabuCSVReader();
        $this->assertInstanceOf(CNabuCSVReader::class, $reader);
        $this->assertInstanceOf(INabuDataListReader::class, $reader);
        $this->assertInstanceOf(INabuDataListFileReader::class, $reader);

        $reader = new CNabuCSVReader(__DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'basic-csv-file.csv');
        $this->assertInstanceOf(CNabuCSVReader::class, $reader);
        $this->assertInstanceOf(INabuDataListReader::class, $reader);
        $this->assertInstanceOf(INabuDataListFileReader::class, $reader);

        $this->expectException(Error::class);
        $this->expectExceptionMessage('resources' . DIRECTORY_SEPARATOR . 'not-exists.csv');
        $reader = new CNabuCSVReader(__DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'not-exists.csv');
    }

    /**
     * @test __construct
     * @test getValidMIMETypes
     * @test customFileValidation
     * @test openSourceFile
     * @test closeSourceFile
     * @test createDataListInstance
     * @test getSourceDataAsArray
     * @test checkBeforeParse
     * @test parse
     */
    public function testParseAsSingleArray()
    {
        $reader = new CNabuCSVReader(
            __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'basic-csv-file.csv',
            array(
                'col_1' => 'value_1',
                'col_2' => 'value_2',
                'col_3' => 'value_3'
            ),
            array(
                'value_1', 'value_2'
            ),
            false, 0, 1
        );
        $this->assertInstanceOf(CNabuCSVReader::class, $reader);
        $this->assertInstanceOf(INabuDataListReader::class, $reader);
        $this->assertInstanceOf(INabuDataListFileReader::class, $reader);

        $data = $reader->parse();
        $this->assertSame(3, count($data));

        for ($i = 1; $i < 4; $i++) {
            for ($j = 1; $j < 4; $j++) {
                $this->assertTrue($data->getItem($i - 1)->isValueEqualTo("value_$j", "value $i.$j"));
            }
        }
    }

    /**
     * @test __construct
     * @test getValidMIMETypes
     * @test customFileValidation
     * @test openSourceFile
     * @test closeSourceFile
     * @test createDataListInstance
     * @test getSourceDataAsArray
     * @test checkBeforeParse
     * @test parse
     */
    public function testParseAsIndexedArray()
    {
        $reader = new CNabuCSVReader(
            __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'basic-csv-file.csv',
            array(
                'col_1' => 'value_1',
                'col_2' => 'value_2',
                'col_3' => 'value_3'
            ),
            array(
                'value_1', 'value_2'
            ),
            false, 0, 1
        );
        $this->assertInstanceOf(CNabuCSVReader::class, $reader);
        $this->assertInstanceOf(INabuDataListReader::class, $reader);
        $this->assertInstanceOf(INabuDataListFileReader::class, $reader);
        $this->assertSame(',', $reader->getDelimiter());
        $this->assertSame('"', $reader->getEnclosure());

        $reader->setIndexField('value_1');
        $this->assertSame('value_1', $reader->getIndexField());

        $reader->setDelimiter(',');
        $this->assertSame(',', $reader->getDelimiter());

        $reader->setEnclosure('"');
        $this->assertSame('"', $reader->getEnclosure());

        $reader->setEscapeCharacter('\\');
        $this->assertSame('\\', $reader->getEscapeCharacter());

        $data = $reader->parse();
        $this->assertSame(3, count($data));

        for ($i = 1; $i < 4; $i++) {
            for ($j = 1; $j < 4; $j++) {
                $this->assertTrue($data->getItem("value $i.1")->isValueEqualTo("value_$j", "value $i.$j"));
            }
        }
    }
}
