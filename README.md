# SimpleXMLTool
SimpleXMLTool - tool to generate a simple XML document, convert XML to Array and JSON

### Data

    $data = array(
        'val1' => 111,
        'val2' => '222',
        'val3' => 333,
        500,
        'container' => array(
            'mystr' => 'test test',
            'myobj' => array(
                'x' => 250,
                'y' => 150,
                'name' => 'objName'
            )
        )
    );

### Generate XML:

code:

    echo $xml = SimpleXMLTool::createXML($data);

out:

    <?xml version="1.0" encoding="UTF-8"?>
    <root>
      <val1>111</val1>
      <val2>222</val2>
      <val3>333</val3>
      <item0>500</item0>
      <container>
        <mystr>test test</mystr>
        <myobj>
          <x>250</x>
          <y>150</y>
          <name>objName</name>
        </myobj>
      </container>
    </root>

### Convert XML to JSON:

code:    
    
    echo SimpleXMLTool::XMLtoJSON($xml);

out:
    
    {"val1":"111","val2":"222","val3":"333","item0":"500","container":{"mystr":"test test","myobj":{"x":"250","y":"150","name":"objName"}}}

### Convert XML to JSON:

code:    
 
    print_r(SimpleXMLTool::XMLtoArr($xml));

out:
    
    Array
    (
        [val1] => 111
        [val2] => 222
        [val3] => 333
        [item0] => 500
        [container] => Array
            (
                [mystr] => test test
                [myobj] => Array
                    (
                        [x] => 250
                        [y] => 150
                        [name] => objName
                    )
            )
    )