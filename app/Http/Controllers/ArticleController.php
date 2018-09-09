<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entities = Article::with('user')->get();

        return view('article.index', ['entities' => $entities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.create', ['entity' => new Article()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());

        try {
            $this->save($request, new Article());

            return redirect()->route('articles.index')->with('success', 'Resource successfully saved.');
        } catch (\Exception $e) {
            Log::critical($e->getMessage());

            return redirect()->route('articles.index')->with('error', 'There seems to be an error. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        dd($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('article.edit', ['entity' => $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->validate($this->getValidationRules());

        try {
            $this->save($request, $article);

            return redirect()->route('articles.index')->with('success', 'Resource successfully saved.');
        } catch (\Exception $e) {
            Log::critical($e->getMessage());

            return redirect()->route('articles.index')->with('error', 'There seems to be an error. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->comments()->delete();
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Resource successfully deleted.');
    }

    /**
     * Store/Update Entity
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \App\Article  $article
     */
    private function save(Request $request, Article $article)
    {
        $article->title = $request->get('title');
        $article->user_id = Auth::id();
        $article->status = 'PUBLISHED';
        $article->description = $request->get('description');
        $article->body = $request->get('body');
        $article->save();
        
        return $article;
    }

    /**
     * Get article validation rules
     *
     * @return array
     */
    private function getValidationRules()
    {
        return [
            'title' => 'required|max:255',
            // 'status' => 'required',
            'description' => 'required',
            'body' => 'required',
        ];
    }
}
