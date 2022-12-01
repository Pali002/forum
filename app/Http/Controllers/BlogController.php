<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Validator;
use App\Models\Blog;
use App\Http\Resources\Blog as BlogResource;

class BlogController extends BaseController {
    

    public function index() {

        $blog = Blog::all();

        return $this->sendResponse(BlogResource::collection($blogs), "OK");
    }

    public function store(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [
            "title" => "required",
            "description" => "required"
        ]);

        if($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $blog = Blog::create($input);

        return $this->sendResponse(new BlogResource($blog), "Post létrehozva");
    }

    public function show($id) {

        $blog = Blog::find($id);

        if(is_null($blog)) {

            return $this->sendError("Post nem létezik");
        }

        return $this->sendResponse(new BlogResource($blog), "Post betöltve");
    }

    public function update( Request $request, $blog) {

        $input = $request->all();
        $validator = Validator::make( Input, [
            "title" => "required",
            "description" => "required"
        ]);

        if($validator->fails()) {
            
            return $this->sendError($validator->errors());
        }

        $blog->title = $input["title"];
        $blog->description = $input["discription"];
        $blog->save();

        return $this->sendResponse(new BlogResource($blog), "Post frissítve");
    }

    public function destroy(Blog $blog) {

        $blog->delete();

        return $this->sendResponse([], "Post törölve");
    }
}
