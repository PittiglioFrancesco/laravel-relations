<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validazione dei dati
        $request->validate([
            'title' => 'required|max:60',
            'content' => 'required'
        ]);
        //prendere i dati
        $data = $request -> all();
        //creare la nuova istanza con i dati ottenuti dalla request
        $new_post = new Post();

        $slug = Str::slug($data['title'], '-');

        $slug_base = $slug;
        $slug_presente = Post::where('slug', $slug)->first();

        $count = 1;
        while ($slug_presente) {
            $slug = $slug_base . '-' . $count;

            $slug_presente = Post::where('slug', $slug)->first();

            $count++;
        }
        
        $new_post->slug = $slug;
        $new_post->fill($data);

        $new_post->save();

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:60',
            'content' => 'required'
        ]);

        $data = $request->all();
        if ($data['title'] != $post->title) {

            $slug = Str::slug($data['title'], '-');
            $slug_base = $slug;

            $slug_presente = Post::where('slug', $slug)->first();

            $count = 1;
            while ($slug_presente) {

                $slug = $slug_base . '-' . $count;

                $slug_presente = Post::where('slug', $slug)->first();
                
                $count++;
            }

            $data['slug'] = $slug;

        }
        
        $post->update($data);

        return redirect()->route('admin.posts.index')->with('updated', 'Hai modificato con successo il post ' . $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
