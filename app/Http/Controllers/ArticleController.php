<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Psy\CodeCleaner\ReturnTypePass;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; 

class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
           new Middleware('permission:view articles',only: ['index']),
           new Middleware('permission:edit articles',only: ['edit']),
           new Middleware('permission:create articles',only: ['create']),
           new Middleware('permission:delete articles',only: ['destroy']),  
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'DESC')->paginate('10');
        return view('articles.list', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5',
            'author' => 'required|min:5',
        ]);
        Article::create(['title' => $request->title, 'author' => $request->author, 'text' => $request->text]);
        return redirect()->route('articles.index')->with('success', 'Article added sucessfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|min:5',
            'author' => 'required|min:5',
        ]);
        $article = Article::findOrFail($id);
        $article->update([
            'title' => request('title'),
            'author' => request('author'),
            'text' => request('text')
        ]);
        return redirect()->route('articles.index')->with('success', 'Article updated sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $article = Article::findOrFail($request->id);
        if ($article == null) {
            session()->flash('error', 'Article Not Found');
            return response()->json([
                'status' => false,
            ]);
        } else {
            $article->delete();
            session()->flash('error', 'Article Deleted Successfully');
            return response()->json([
                'status' => true,
            ]);
        }
    }
}
