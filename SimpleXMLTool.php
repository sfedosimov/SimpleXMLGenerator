<?php

    /**
     * Class SimpleXMLTool
     * Tool to generate a simple XML document
     *
     * @author    Sergey Fedosimov
     * @copyright 2015 Sergey Fedosimov
     */
    class SimpleXMLTool
    {
        /**
         * Get XML by Array
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
         * Recursive function for generating node.
         *
         * @param DOMDocument $dom
         * @param DOMElement  $el
         * @param array       $ar
         *
         * @param null        $last
         *
         * @return DOMElement
         */
        private static function createXMLElement(DOMDocument $dom, DOMElement $el, array $ar, $last = null)
        {
            foreach ($ar as $tag => $value) {
                $tag = is_numeric($tag) ? $last : $tag;

                if (is_array($value)) {
                    $$tag = (!self::isNumIndex($value)) ? $el->appendChild($dom->createElement($tag)) : $el;
                    self::createXMLElement($dom, $$tag, $value, $tag);
                } else {
                    $el->appendChild($dom->createElement($tag, $value));
                }
            }

            return $el;
        }

        /**
         * Checks array keys
         *
         * @param array $ar
         *
         * @return bool
         */
        private function isNumIndex(array $ar)
        {
            foreach ($ar as $key => $value) {
                if (is_numeric($key)) {
                    return true;
                }
            }

            return false;
        }


        /**
         * Get SimpleXMLElement where merge CDATA as text nodes
         *
         * @param string $xml
         *
         * @return SimpleXMLElement
         */
        private static function getXMLNOCDATA($xml)
        {
            return simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
        }

        /**
         * Get Array by XML
         *
         * @param string $xml
         *
         * @return mixed
         */
        public static function XMLtoArr($xml)
        {
            $json = self::XMLtoJSON($xml);

            return json_decode($json, true);
        }

        /**
         * Get JSON by XML
         *
         * @param string $xml
         *
         * @return string
         */
        public static function XMLtoJSON($xml)
        {
            $xml_obj = self::getXMLNOCDATA($xml);

            return json_encode($xml_obj);
        }
    }