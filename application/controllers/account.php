<?php
/**
 *
 * User: user1
 * Date: 12/27/12
 * Time: 10:17 PM
 * Copyright (c) 2012 Quantum Logic Corporation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 */


class Account_Controller extends Base_Controller {

    public function action_index() {
        return "This is the account index.";
    }

    public function action_login() {
        echo Form::open('account');
        echo Form::label('username','Username');
        echo Form::text('username');
        echo Form::submit('Login');
        echo Form::close();

    }


    public function action_demo() {

        $menu = lextjs::menu(200)
            ->with(lextjs::menuitem("hi"))
            ->with(lextjs::menuitem("ho"))
            ->with(lextjs::menuitem("ha"));

        $menubutton = lextjs::buttonmenu("Button Menu", false)
            ->with(lextjs::buttonitem("mb1", new LextjsClosure("alert('Item 1 clicked');")))
            ->with(lextjs::buttonitem("mb2", new LextjsClosure("alert('Item 2 clicked');")))
            ->with(lextjs::buttonitem("mb3", new LextjsClosure("alert('Item 3 clicked');")));

        $regularbutton = lextjs::button("Regular button");

        //$panel = lextjs::panel()->with($regularbutton)->with($menubutton)->with($menu);

        $panel = lextjs::panel("My First Panel", null, true)->with(
            lextjs::toolbar(400)->with($menubutton)->with(lextjs::tbspacer(50))->with(lextjs::tbseparator())
        );

        $lext_js = Lextjs::make()
            ->with($panel)
            ;

        $lext_form = Lextjs::form("My First Form", "http://www.quantum-logic.com")
            ->with(lextjs::formset("My First Field Set")->with(lextjs::formtext('My first text field')));

        $lext_js = Lextjs::make()
            ->with($lext_form)
        ;


        $lext_js->render();

    }
}

