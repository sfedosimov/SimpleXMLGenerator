<?php

    /**
     * Class SimpleXMLGenerator
     * Tool to generate a simple XML document
     *
     * @author    Sergey Fedosimov
     * @copyright 2015 Sergey Fedosimov
     */
    class SimpleXMLGenerator
    {
        /**
         * Генерация XML
         *
         * @param array $ar
         * @param array $options []
         *                       root_tag   - root tag wraping body xml (example root - <root>...</root>)
         *                       format     - true/false (formatting output XML)
         *                       version    - XML version (<?xml version="1"?>)
         *                       encode     - XML encode (<?xml encode="UTF-8"?>)
         *                       nohead     - XML output without "<?xml" header
         *
         * @return string
         */
        public static function createXML(array $ar, $options = array())
        {

            $root_tag = (isset($options['root_tag'])) ? $options['root_tag'] : 'root';
            $format = (isset($options['format'])) ? $options['format'] : true;
            $version = (isset($options['version'])) ? $options['version'] : '1.0';
            $encode = (isset($options['encode'])) ? $options['encode'] : 'UTF-8';
            $nohead = (isset($options['nohead'])) ? $options['nohead'] : false;

            $dom = new domDocument($version, $encode);
            $root = $dom->appendChild($dom->createElement($root_tag));

            self::createXMLElement($dom, $root, $ar);

            $dom->formatOutput = $format;

            if ($nohead) {
                return $dom->saveXML($root);
            }

            return $dom->saveXML();
        }

        /**
         * Recursive function for generating node
         *
         * @param DOMDocument $dom
         * @param DOMElement  $el
         * @param array       $ar
         *
         * @return DOMElement
         */
        private static function createXMLElement(DOMDocument $dom, DOMElement $el, array $ar)
        {
            foreach ($ar as $tag => $value) {
                if (is_array($value)) {
                    $$tag = $el->appendChild($dom->createElement($tag));
                    self::createXMLElement($dom, $$tag, $value);
                } else {
                    $el->appendChild($dom->createElement($tag, $value));
                }
            }

            return $el;
        }
    }