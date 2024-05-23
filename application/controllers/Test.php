<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
use chriskacerguis\RestServer\RestController;

class Test extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    // called when a GET request is made for test/index - note the URL is for test/index, not test/index_get
    public function index_get()
    {
        $this->load->view('Auth/register');
    }

    public function index_post()
    {
        // just a test message to know the right function has been called
        print "hi, index_post() called";
    }

    public function index_put()
    {
        // just a test message to know the right function has been called
        print "hello, index_put() called";
    }

    // called when the ajax call in testview calls Test/index with the DELETE request method
    public function index_delete()
    {
        // just a test message to know the right function has been called
        print "hello, index_delete() called";
    }
    

}
