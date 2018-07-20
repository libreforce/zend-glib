# zend-glib
GLib code generator from Zend Framework


```
./vendor/bin/phpunit --bootstrap vendor/autoload.php test/DocBlockTest.php
./vendor/bin/phpunit --bootstrap vendor/autoload.php --configuration phpunit.xml
```


generate($scope)
useScopes(array('source'));
useScopes(array('source', 'header', 'typedef'));

typedef
header
header-boiler
source
source-boiler

TODO:
ClassGenerator
MethodGenerator
TypeGenerator
 -> gboolean
 -> gint
 -> gfloat
 -> glong




DOMNode dom_node_append_child(DOMNode child)
NameingGenerator('DOMNode')->generate(typedef) == 'DOMNode'
NameingGenerator('DOMNode')->generate(boilerplate) == 'dom_node'


 


DomNode:
- dom_node             (prefix|source-boiler)
- DOM_NODE/DOM_IS_NODE (macro|header-boiler)
- DOMNode              (typedef)
- child-appended       (signal|property)
- node.h/node.c        (signal|property)


typedef
header
header-boiler
source
source-boiler


zend-idl
zend-glib

tools/gen-idl.php => parse idl and export to glib GObject
tools/gen-idl.php => parse idl and export to JavascriptCore

