<?php
/**
 *
 * User: user1
 * Date: 12/15/12
 * Time: 2:48 PM
 * Copyright (c) 2012 Quantum Logic Corporation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 */


abstract class LextjsSuperclass {
    protected $xargs = array();

    public function __construct($default_xargs = null, $user_xargs = null) {

        if ($default_xargs) {
            $this->xargs = $default_xargs;
        }

        if ($user_xargs) {
            foreach ($user_xargs as $xkey => $xvalue) {
                $this->xargs[$xkey] = $xvalue;
            }
        }
    }

    protected  function render($children = null, $child_type = null) {
        $data = "";

        error_log("base rendering...");
        foreach ($this->xargs as $xkey => $xvalue) {
            //var_dump($xvalue);

            if ($data) {
                $data .= ', ';
            }
            $data .= $xkey . ': ';

            if (is_numeric($xvalue)) {
                $data .= $xvalue;
            }
            elseif (is_bool($xvalue)) {
                $data .= ($xvalue) ? 'true' : 'false';
            }
            elseif (is_object($xvalue)) {
                $data .= $xvalue->render();
            }
            else {
                $data .= '\'' . $xvalue . '\'';
            }
        }

        if ($children) {
            error_log("rendering children...");

            $first_flag = true;

            //$data .= ", items: [\n";
            $data .= ", " . $child_type . ": [\n";
            foreach ($children as $item) {

                if (!$first_flag) {
                    $data .= ",\n";
                }
                $first_flag = false;

                $data .= '{';
                error_log("rendering child:");
                $data .= $item->render();
                $data .= '}';
            }

            $data .= " ]\n";
        }

        error_log("rendered data: $data");

        return $data;
    }
}


 class LextjsComponent extends LextjsSuperclass {

}

class LextjsClosure {
    private $func_text= null;

    public function __construct($func_text = null) {
        $this->func_text = 'function() { ' . $func_text . '}';
    }

    public function render() {
        return $this->func_text;
    }

}

class LextjsContainer extends LextjsComponent {

    private $children = array();
    private $child_type = "items";


    public function __construct($default_xargs = null, $user_xargs = null, $child_type = null) {
        if ($child_type) {
            $this->child_type = $child_type;
        }
        parent::__construct($default_xargs, $user_xargs);
    }



    public function with($child) {
        if (is_array($child)) {
            $this->children = array_merge($this->children, $child);
        }
        else {
            $this->children[] = $child;
        }
        return $this;
    }

    public  function render($children = null, $child_type = null) {
        error_log("lextjs_container::lext_render");
        return parent::render($this->children, $this->child_type);
    }
}

class Lextjs extends LextjsContainer {

    public static function make() {
        return new static();
    }

    public function render($children = null, $child_type = null) {
       //echo parent::lext_render();
       echo View::make('lextjs-view')->with('render', parent::render());
       //echo "hello, world";
    }

    /*** MENU ***/
    public static function menu($width = 0, $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'menu',
            'width' => 100,
            'margin' => '0 0 10 0',
            'floating' => false,
        );

        if ($width) {
            $default_xargs['width'] = $width;
        }

        return new LextjsContainer($default_xargs, $user_xargs);
    }

    public static function menuitem($text = "", $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'menuitem',
            'text' => 'Menu Item',
        );

        if ($text) {
            $default_xargs['text'] = $text;
        }
        return new LextjsComponent($default_xargs, $user_xargs);
    }

    public static function menucheck($text = "", $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'menucheckitem',
            'text' => 'Menu Check Item',
        );

        if ($text) {
            $default_xargs['text'] = $text;
        }
        return new LextjsComponent($default_xargs, $user_xargs);
    }

    /*** BUTTON ***/
    public static function buttonmenu($width = 0, $split = false, $user_xargs = null) {
        $default_xargs = array(
            'xtype' => ($split) ? 'splitbutton' : 'button',
            'text' => ($split) ? 'Split Button' : 'Regular Button'
        );

        return new LextjsContainer($default_xargs, $user_xargs, 'menu');
    }

    public static function button($text = "", $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'button',
            'text' => 'Button Text'
        );

        if ($text) {
            $default_xargs['text'] = $text;
        }
        return new LextjsComponent($default_xargs, $user_xargs);
    }

    public static function buttonitem($text = "", $handler = null, $user_xargs = null) {
        $default_xargs = array(
            'text' => 'Button Item',
            'handler' => null
        );

        if ($text) {
            $default_xargs['text'] = $text;
        }
        if ($handler) {
            $default_xargs['handler'] = $handler;
        }
        return new LextjsComponent($default_xargs, $user_xargs);
    }

    /*** PANEL ***/
    public static function panel($title = null, $width = 0, $draggable = false, $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'panel',
            'title' => 'Panel Title'
        );

        if ($title) {
            $default_xargs['title'] = $title;
        }

        if ($draggable) {
            $default_xargs['draggable'] = $draggable;
        }

        if ($width) {
            $default_xargs['width'] = $width;
        }

        return new LextjsContainer($default_xargs, $user_xargs);
    }

    /*** TOOLBAR ***/
    public static function toolbar($width = 0, $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'toolbar',
        );

        if ($width) {
            $default_xargs['width'] = $width;
        }

        return new LextjsContainer($default_xargs, $user_xargs);
    }

    public static function tbfill($width = 0, $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'tbfill',
        );

        return new LextjsComponent($default_xargs, $user_xargs);
    }

    public static function tbseparator($width = 0, $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'tbseparator',
        );

        return new LextjsComponent($default_xargs, $user_xargs);
    }

    public static function tbspacer($width = 0, $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'tbspacer',
        );

        if ($width) {
            $default_xargs['width'] = $width;
        }

        return new LextjsComponent($default_xargs, $user_xargs);
    }

    /*** FORM ***/
    public static function form($title = null, $url = null, $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'form',
            'title' => 'Form Title',
        );

        if ($title) {
            $default_xargs['title'] = $title;
        }

        if ($url) {
            $default_xargs['url'] = $url;
        }


        return new LextjsContainer($default_xargs, $user_xargs);
    }

    public static function formcontainer($label = null, $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'fieldcontainer',
            'fieldLabel' => 'Field Label',
        );

        return new LextjsContainer($default_xargs, $user_xargs);
    }

    public static function formset($title = null, $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'fieldset',
            'title' => 'Title',
        );

        if ($title) {
            $default_xargs['title'] = $title;
        }

        return new LextjsContainer($default_xargs, $user_xargs);
    }

    public static function formtext($label = null, $name = null, $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'textfield',
            'fieldLabel' => "Field Label",
        );

        if ($label) {
            $default_xargs['fieldLabel'] = $label;
        }

        if ($name) {
            $default_xargs['name'] = $name;
        }

        return new LextjsComponent($default_xargs, $user_xargs);
    }

}

/*
$lext_js = Lextjs::make()
    ->with(Lextjs::menu(200)
        ->with(Lextjs::menuitem("hi"))
        ->with(Lextjs::menuitem("ho"))
        ->with(Lextjs::menuitem("ha"))

    );

$lext_js->lext_render();

*/