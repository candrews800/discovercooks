<?php

class BlogController extends BaseController {

    public function index(){
        $recent_posts = BlogPost::orderBy('id', 'desc')->paginate(5);

        $archive = DB::table('blog_posts')->select(DB::raw('YEAR(created_at) AS YEAR, MONTH(created_at) AS MONTH, MONTHNAME(created_at) AS MONTHNAME, COUNT(*) AS TOTAL'))
            ->groupBy(DB::raw('YEAR, MONTH'))->get();

        return View::make('blog.index')->with(array(
            'recent_posts' => $recent_posts,
            'archive' => $archive
        ));
    }

    public function addComment(BlogPost $blog_post){
        $input = Input::all();

        $comment = new BlogComment();
        $comment->blog_id = $blog_post->id;
        $comment->author_id = Auth::id();
        $comment->text = trim($input['text']);

        $comment->save();

        return Redirect::back();
    }

    public function deleteComment($comment_id){
        $comment = BlogComment::find($comment_id);
        $comment->delete();

        return Redirect::back();
    }

    public function single(BlogPost $blog_post){
        $recent_posts = BlogPost::orderBy('id', 'desc')->paginate(5);
        $comments = BlogComment::where('blog_id', '=', $blog_post->id)->orderBy('created_at', 'asc')->get();
        foreach($comments as $key=>$comment) {
            $comment->user = User::find($comment->author_id);
            if (!$comment->user){
                unset($comments[$key]);
            }
        }

        $archive = DB::table('blog_posts')->select(DB::raw('YEAR(created_at) AS YEAR, MONTH(created_at) AS MONTH, MONTHNAME(created_at) AS MONTHNAME, COUNT(*) AS TOTAL'))
            ->groupBy(DB::raw('YEAR, MONTH'))->get();

        return View::make('blog.single')->with(array(
            'recent_posts' => $recent_posts,
            'post' => $blog_post,
            'comments' => $comments,
            'archive' => $archive
        ));
    }

    public function archive($year, $month){
        $recent_posts = BlogPost::whereRaw('YEAR(created_at) = '.$year)->whereRaw('MONTH(created_at) = '.$month)->orderBy('id', 'desc')->get();

        if($recent_posts->isEmpty()){
            return Redirect::to('blog');
        }

        $archive = DB::table('blog_posts')->select(DB::raw('YEAR(created_at) AS YEAR, MONTH(created_at) AS MONTH, MONTHNAME(created_at) AS MONTHNAME, COUNT(*) AS TOTAL'))
            ->groupBy(DB::raw('YEAR, MONTH'))->get();

        return View::make('blog.archive')->with(array(
            'recent_posts' => $recent_posts,
            'archive' => $archive
        ));
    }
}
