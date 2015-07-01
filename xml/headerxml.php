<?php

function headerXml(){
    $dom = new DomDocument('1.0', 'utf-8');
    $items = $dom->createElement('items');
    $items->appendChild($dom);

    $text = $items->createTextNode('aaa');
    $items->appendChild($text);

    $attribute = $items->createAttribute('attr');
    $items->appendChild($attribute);
    $attr_text = $attribute->createTextNode('attr text');
    $attribute->appendChild($attr_text);

    header('Content-type: text/xml');
    echo $dom->saveXml();
}

headerxml();