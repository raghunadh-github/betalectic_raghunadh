<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\blog;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index() {
        try{
            $blogs = blog::where('author_id', Auth::user()->id)->orderBy('created_at','desc')->get();
            $title = 'All Posts';
            return view('blogs', compact('blogs', 'title'));
        }catch(Exception $e){
            return redirect()->route('blogs')->with('error', 'Something went wrong. Try again');
        }
    }

    public function create() {
        return view('newBlog');
    }

    public function store(Request $request){
        try{
            $request->slug = Str::slug($request->slug);
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
                'slug'  => ['required', Rule::unique('blogs')]
            ]);

            if($validator->fails()){
                $message = $validator->errors();
                return redirect()->route('blog.new')->with('error', $message)->withInput();
            }else{                  
                blog::create([
                    'author_id' => Auth::user()->id,
                    'title'     => $request->title,
                    'content'   => $request->content,
                    'slug'      => $request->slug
                ]);

                return redirect()->route('blog.new')->with('success', 'Blog post published successfully');
            }
        }catch(Exception $e){
            return redirect()->route('blog.new')->with('error', 'Something went wrong. Try again');
        }
    }

    public function show($id){
        try{
            $blog = blog::where('id', $id)->first();
            if($blog && (Auth::user()->id == $blog->author_id)){
                return view('showBlog', compact('blog'));
            }else{                
                return redirect('blogs')->with('error', 'requested page not found');
            }
        }catch(Exception $e){
            return redirect()->route('blogs')->with('error', 'Something went wrong. Try again');
        }
    }

    public function edit($id) {
        try{
            $blog = blog::where('id', $id)->first();
            if($blog && (Auth::user()->id == $blog->author_id)){
                return view('editBlog', compact('blog'));
            }else{
                return redirect('blogs')->withErrors('you have not sufficient permissions');
            }       
        }catch(Exception $e){
            return redirect()->route('blogs')->with('error', 'Something went wrong. Try again');
        }        
    }

    public function update(Request $request){
        try{
            $request->slug = Str::slug($request->slug);
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
                'slug'  => ['required', Rule::unique('blogs')->ignore($request->id)]
            ]);

            if($validator->fails()){
                $message = $validator->errors();
                return redirect()->route('blog.list')->with('error', $message)->withInput();
            }else{
                blog::where('id', $request->id)->update([
                    'author_id' => Auth::user()->id,
                    'title'     => $request->title,
                    'content'   => $request->content,
                    'slug'      => $request->slug
                ]);

                return redirect()->route('blogs')->with('success', 'Blog post published successfully');
            }
        }catch(Exception $e){
            return redirect()->route('blogs')->with('error', 'Something went wrong. Try again');
        }
    }

    public function destroy(Request $request, $id){
        $blog = blog::find($id);
        if($blog && ($blog->author_id == Auth::user()->id)){
            $blog->delete();
            $data['success'] = 'Blog deleted Successfully';
        }
        else{
            $data['errors'] = 'Invalid Operation. You have not sufficient permissions';
        }
        return redirect('blogs')->with($data);
    }
}
