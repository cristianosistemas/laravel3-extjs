<?php
/**
 *
 * User: user1
 * Date: 12/16/12
 * Time: 3:09 PM
 * Copyright (c) 2012 Quantum Logic Corporation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 *
 *
Ext.create('Ext.container.Viewport', {
items: [ { html: 'before menu'}, {
xtype: 'menu',
width: 100, margin: '0 0 10 0', floating: false,
items: [{
text: 'regular item 1'
},{
text: 'regular item 2'
},{
text: 'regular item 3'
}]}, { html: 'after menu'}
]
});
 *
 */
?>
<html>
<head>
    <link href="http://laravel3/ext-4.1.1a/resources/css/ext-all-debug.css" media="all" type="text/css" rel="stylesheet">
    <script src="http://laravel3/ext-4.1.1a/ext-all-debug.js" type="text/javascript"></script>
    <script type="text/javascript">
        Ext.onReady(function() {

            Ext.create('Ext.container.Viewport', {
                <?php echo $render."\n"; ?>
                });

        });
    </script>
<?php


    //echo $render;
?>
</head>
<body></body>
</html>