<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Article;
use App\Comment;

class BlogController extends Controller
{
    /**
     * Show the Blog.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entities = Article::with(['user', 'comments'])->get();

        return view('blog.index', ['entities' => $entities]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function showArticle(Article $article)
    {
        return view('blog.article', ['entity' => $article]);
    }

    /**
     * Add article comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request, Article $article)
    {
        $request->validate([
            'nickname' => 'required|max:255',
            'comment' => 'required',
        ]);

        try {
            $comment = new Comment();
            $comment->nickname = $request->get('nickname');
            $comment->comment = $request->get('comment');   
            $comment->article_id = $article->id;
            $comment->save();       

            return redirect()->route('blog.article', ['article' => $article->id])->with('success', 'Comment successfully added.');
        } catch (\Exception $e) {
            Log::critical($e->getMessage());

            return redirect()->route('blog.article', ['article' => $article->id])->with('error', 'There seems to be an error. Please try again.');
        }
    }

}
