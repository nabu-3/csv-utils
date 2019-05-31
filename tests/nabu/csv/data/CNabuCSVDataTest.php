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

namespace nabu\csv\data;

use PHPUnit\Framework\TestCase;

use nabu\data\interfaces\INabuDataList;

/**
 * Tests for class @see {CNabuCSVData }.
 * @author Rafael Gutierrez <rgutierrez@nabu-3.com>
 * @since 3.0.0
 * @version 3.0.0
 * @package \nabu\csv\data
 */
class CNabuCSVDataTest extends TestCase
{
    /**
     * @test __construct
     * @test acquireItem
     * @test createDataInstance
     */
    public function testClass()
    {
        $csv_data = new CNabuCSVData('field_key');
        $this->assertInstanceOf(CNabuCSVData::class, $csv_data);
        $this->assertInstanceOf(INabuDataList::class, $csv_data);

        $this->assertNull($csv_data->getItem('test'));

        $record = $csv_data->createItemFromArray(array('field_key' => 1, 'field_value' => 'Myself'));
        $this->assertInstanceOf(CNabuCSVDataRecord::class, $record);
        $this->assertSame(1, $record->getValue('field_key'));
        $this->assertSame('Myself', $record->getValue('field_value'));
    }
}
