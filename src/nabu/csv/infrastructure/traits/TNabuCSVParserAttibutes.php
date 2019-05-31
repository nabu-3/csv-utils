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

namespace nabu\csv\infrastructure\traits;

/**
 * Trait to manage CSV Parser attributes like delimiter, enclosure or escape character.
 * @author Rafael Gutierrez <rgutierrez@nabu-3.com>
 * @since 3.0.0
 * @version 3.0.0
 * @package \nabu\csv\data
 */
trait TNabuCSVParserAttributes
{
    /** @var string CSV Field delimiter. */
    protected $delimiter = ',';
    /** @var string|null CSV Field enclosure. */
    protected $enclosure = '"';
    /** @var string|null CSV Escape Character. */
    protected $escapeCharacter = "\\";

    /**
     * Get the Delimiter between CSV fields.
     * @return string Return current delimiter.
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * Set the Delimiter between CSV fields.
     * @param string $delimiter The delimiter string to set.
     * @return mixed Return the self pointer to grant Fluent Interface.
     */
    public function setDelimiter(string $delimiter)
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * Get the enclosure character of a CSV field.
     * @return string Return current enclosure.
     */
    public function getEnclosure(): string
    {
        return $this->enclosure;
    }

    /**
     * Set the enclosure character of a CSV line.
     * @param string $enclosure New enclosure to set.
     * @return mixed Return the self pointer to grant Fluent Interface.
     */
    public function setEnclosure(string $enclosure)
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    /**
     * Get the escape character of a CSV field.
     * @return string Return current escape character.
     */
    public function getEscapeCharacter(): string
    {
        return $this->escapeCharacter;
    }

    /**
     * Set the escape character of a CSV field.
     * @param string $escape New escape character to set.
     * @return mixed Return the self pointer to grant Fluent Interface.
     */
    public function setEscapeCharacter(string $escape)
    {
        $this->escapeCharacter = $escape;

        return $this;
    }
}
