<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post; // using any of the model funcions
use DB; // use SQL queries instead of Eloquent but it's better to use Eloquent
use Illuminate\Support\Facades\Storage; // to be able to delete images

class PostsController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // create exceptions to the user see even unauthenticated
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // fetch all data in the table with Eloquent
        //$posts = Post::all();
        
        // get the data ordered by some field. It's needed the get() at the end
        //$posts = Post::orderBy('title', 'desc')->get(); // asc or desc
        
        // get individual post: use Post:: (because its a model)
        //$post = Post::where('title', 'Post Two')->get();

        // using SQL, but it's better to use Eloquent most common
        //$posts = DB::select('SELECT * FROM posts ORDER BY title DESC');

        // limiting posts, usign take()
        //$posts = Post::orderBy('title', 'desc')->take(1)->get();

        // pagination.. use  $posts->links() in the index.blade.php
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        // loading view with the posts 
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // called when go to posts/create
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // create calls a form and then when submit that form store is called
        // validate data with array of rules
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // handle file upload
        if ($request->hasFile('cover_image')) {
            // if person select something
            // Get filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); // just php to extract the name

            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // filename with timestamp to make the names unique
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // Upload image in folder cover_images
            // create a folder if doesn't exists and store the file there
            // create at storege/app/public/images
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

            // need to create an link to be accessable for the users
            // using php artisan storage:link
            // everything in store will be accessable there

        } else {
            // if don't submit image put a name to put in the DB
            $fileNameToStore = 'noimage.jpg';
        }

        // use tinker to save data
        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        // send the messages to use the messages file. To give the user notifications
        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // the id is passed for the function
        $post = Post::find($id); // find specific post and return it with Eloquent
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id); // find specific post and return it with Eloquent

        // check for correct user
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        // handle file upload
        if ($request->hasFile('cover_image')) {
            // if person select something
            // Get filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); // just php to extract the name

            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // filename with timestamp to make the names unique
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // Upload image in folder cover_images
            // create a folder if doesn't exists and store the file there
            // create at storege/app/public/images
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        // use tinker to save data
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('cover_image')) {
            // delete previous if not noimage.jpg
            if ($post->cover_image != 'noimage.jpg') {
                Storage::delete('public/cover_images/'.$post->cover_image);
            }

            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        // send the messages to use the messages file. To give the user notifications
        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        
        // check for correct user
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        if ($post->cover_image != 'noimage.jpg') {
            // delete
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->delete();
        return redirect('/posts')->with('success', 'Post Removed');
    }
}
