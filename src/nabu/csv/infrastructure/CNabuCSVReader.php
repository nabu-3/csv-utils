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

use nabu\csv\data\CNabuCSVData;

use nabu\csv\infrastructure\traits\TNabuCSVParserAttributes;

use nabu\data\interfaces\INabuDataList;

use nabu\infrastructure\reader\CNabuAbstractDataListFileReader;

/**
 * Class to read CSV data from a file.
 * @author Rafael Gutierrez <rgutierrez@nabu-3.com>
 * @since 3.0.0
 * @version 3.0.0
 * @package \nabu\csv\data
 */
class CNabuCSVReader extends CNabuAbstractDataListFileReader
{
    use TNabuCSVParserAttributes;

    /** @var string|null Index field name. */
    protected $index_field = null;

    /** @var int CSV File handler. */
    private $csv_handler = 0;

    protected function getValidMIMETypes(): array
    {
        return [
            "text/plain",
            "text/csv"
        ];
    }

    protected function customFileValidation(string $filename): bool
    {
        return true;
    }

    protected function openSourceFile(string $filename): bool
    {
        if ($this->csv_handler === 0) {
            $this->csv_handler = fopen($filename, "r");
        }

        return ($this->csv_handler) > 0;
    }

    protected function closeSourceFile(): void
    {
        if ($this->csv_handler > 0) {
            fclose($this->csv_handler);
            $this->csv_handler = 0;
        }
    }

    protected function createDataListInstance(): INabuDataList
    {
        return new CNabuCSVData($this->index_field);
    }

    protected function getSourceDataAsArray(): ?array
    {
        $data = array();

        while (($row = fgetcsv($this->csv_handler, 0, $this->delimiter, $this->enclosure, $this->escapeCharacter)) !== false) {
            if (is_array($row)) {
                $data[] = $row;
            }
        }

        return $data;
    }

    protected function checkBeforeParse(): bool
    {
        return ($this->csv_handler > 0);
    }

    protected function checkAfterParse(\nabu\data\interfaces\INabuDataList $resultset): bool
    {
        return true;
    }

    /**
     * Get the Index Field used to index data in the result collection.
     * @return string|null Returns the index name if set or null otherwise.
     */
    public function getIndexField(): ?string
    {
        return $this->index_field;
    }

    /**
     * Set the Index Field used to index data in the result collection.
     * @param string|null $index The index field name in the result to use.
     * @return CNabuCSVReader Returns the self pointer to grant Fluent Interface.
     */
    public function setIndexField(?string $index = null): CNabuCSVReader
    {
        $this->index_field = $index;

        return $this;
    }

}
