<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    // name_folder.name_file
    public function index() {
        // return 'INDEX';
        // load a view to show the html and everything
        // it will look into the pages folder the index.php (resources/views/pages/index.blame.php)

        // send value to the template or view
        // 1 way
        // $title = 'Welcome to Laravel!';
        // return view('pages.index', compact('title'));

        // another way, the use of arrays is available here
        $title = 'Welcome to Laravel!';
        return view('pages.index')->with('title', $title);
    }

    public function about() {
        $title = 'About Us';
        return view('pages.about')->with('title', $title);
    }

    public function services() {
        // passing multiple values
        $data = array(
            'title' => 'Services',
            'services' => ['Web Design', 'Programming', 'SEO']
        );
        return view('pages.services')->with($data);
    }
}
