<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Blocks\Section;
use ElementorToGutenberg\Parser\Elementor\Elementor;
use ElementorToGutenberg\Parser\Elementor\Settings;
use DOMDocument;
use HTMLPurifier;
use HTMLPurifier_Config;

class Text extends Elementor
{

    public function run(): string
    {
        $return = '';

        if ( ! empty($this->element->settings->editor)) {
            // Validate HTML
            $config = HTMLPurifier_Config::createDefault();
            $config->set('AutoFormat.AutoParagraph', true);
            $config->set('AutoFormat.RemoveEmpty', true);
            $config->set('CSS.AllowedProperties',
                'font,font-size,font-style,font-family,text-decoration,padding-left,color,background-color,text-align,width');
            $config->set('HTML.Allowed',
                'div[class|style],b,strong,i,em,a[href|title|class|style],ul,ol,li,p[style|class],br,img[style|width|height|alt|src|class],table[style|class],tbody[style|class],thead[style|class],tr[style|class],td[style|class],th[style|class]');

            $purifier = new HTMLPurifier($config);
            $editor   = $purifier->purify($this->element->settings->editor);

            // Parse HTML
            $doc = new DOMDocument('1.0', 'utf-8');
            // Don't use LIBXML_HTML_NOIMPLIED. Instead, use substr below
            // @url https://stackoverflow.com/questions/4879946/how-to-savehtml-of-domdocument-without-html-wrapper
            $doc->loadHTML(mb_convert_encoding($editor, 'HTML-ENTITIES', 'UTF-8'));

            // If nested or multiple tags in line
            // Lists
            $checkTags = ['ol', 'ul'];
            foreach ($checkTags as $tag) {
                $items = $doc->getElementsByTagName($tag);
                if ($items->length > 0) {
                    foreach ($items as $item) {
                        $section = null;

                        if ($this->element->settings->_background_color) {
                            $section = new Section($this->element);
                            $return  .= $section->open();
                        }

                        $return .= $this->html($item);

                        if ($this->element->settings->_background_color) {
                            $return .= $section->close();
                        }
                    }
                }
            }

            // Paragraphs
            $paragraphs = $doc->getElementsByTagName('p');
            foreach ($paragraphs as $item) {
                if ($item->nodeType == XML_ELEMENT_NODE) {
                    $return .= $this->html($item);
                }
            }

            // @TODO Blockquotes
        }

        return $return;
    }

    public function html($item): string
    {
        $return   = '';
        $settings = false;

        $item->encoding = 'UTF-8';

        switch ($item->nodeName) {
            case 'p':
                $settings = new Settings\Paragraph($this->element);
                $tag      = 'wp:paragraph';
                break;
            case 'ul':
                $settings = new Settings\UlList($this->element);
                $tag      = 'wp:list';
                break;
            case 'ol':
                $settings = new Settings\OlList($this->element);
                $tag      = 'wp:list';
                break;
            case 'blockquote';
                // @TODO
                $tag = 'wp:quote';
                break;
            default:
                wp_send_json_error('Unknown text child: ' . $item->nodeName);
                break;
        }

        $style = $settings->css();
        if ( ! empty($style)) {
            $item->setAttribute('style', $style);
            $item->setAttribute('class', $settings->classes());
        }

        if ( ! empty($tag)) {
            $return .= '<!-- ' . $tag . ' ';
            $return .= $settings->json();
            $return .= ' -->';
            $return .= $item->ownerDocument->saveHTML($item);
            $return .= '<!-- /' . $tag . ' -->';
        }

        return $return;
    }
}