<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Webklex\IMAP\Facades\Client;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->server = new Server('mail.javal.ge');
        // // $connection is instance of \Ddeboer\Imap\Connection
        // $this->connection = $this->server->authenticate('contact@javal.ge', 'Qwerty12345@@!');  

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $client = \Webklex\IMAP\Facades\Client::account('default');
        $client->connect();
        $folders = $client->getFolders();

  

        //Loop through every Mailbox
        /** @var \Webklex\PHPIMAP\Folder $folder */
        foreach($folders as $folder){

            //Get all Messages of the current Mailbox $folder
            /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
            $messages = $folder->messages()->all()->get();
            
            print_r($messages);
        }
        
            
		return 0;  
    }
}
