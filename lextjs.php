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

class lextjs_base {
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

    protected  function lext_render($children = null) {
        $data = "";

        error_log("base rendering...");
        foreach ($this->xargs as $xkey => $xvalue) {
            error_log("key:$xkey value: $xvalue");

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
            else {
                $data .= '\'' . $xvalue . '\'';
            }
        }

        if ($children) {
            error_log("rendering children...");
            $data .= $this->lext_render_children($children);
        }

        error_log("rendered data: $data");

        return $data;
    }

    private function lext_render_children($children) {
        $first_flag = true;

        $data = ", items: [\n";
        foreach ($children as $item) {

            if (!$first_flag) {
                $data .= ",\n";
            }
            $first_flag = false;

            $data .= '{';
            error_log("rendering child:");
            $data .= $item->lext_render();
            $data .= '}';
        }

        $data .= "\n]\n";

        return $data;
    }

}

class lextjs_component extends lextjs_base {

}

class lextjs_container extends lextjs_component {
    private $children = array();

    public function with($child) {
        if (is_array($child)) {
            $this->children = array_merge($this->children, $child);
        }
        else {
            $this->children[] = $child;
        }
        return $this;
    }

    public function lrender() {
        error_log("lextjs_container::lrender");
        return parent::lext_render($this->children);
    }

}

class lextjs extends lextjs_container {


    public static function make() {
        return new static();
    }


    public function lrender() {
       //echo parent::lrender();
       echo View::make('lextjs-view')->with('render', parent::lrender());
    }


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

        return new lextjs_container($default_xargs, $user_xargs);
    }

    public static function menuitem($text = "", $user_xargs = null) {
        $default_xargs = array(
            'xtype' => 'menuitem',
            'text' => 'Menu Item',
        );

        if ($text) {
            $default_xargs['text'] = $text;
        }
        return new lextjs_component($default_xargs, $user_xargs);
    }
}


$lextjs = lextjs::make()
    ->with(lextjs::menu(200)
        ->with(lextjs::menuitem("hi"))
        ->with(lextjs::menuitem("ho"))
        ->with(lextjs::menuitem("ha"))

    );

//print_r($lextjs);
//$lextjs->lrender();


