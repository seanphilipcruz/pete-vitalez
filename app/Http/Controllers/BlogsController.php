<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogsController extends Controller
{
    public function index(Request $request) {
        $per_page = $request->get('per_page', 5);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $column_name = $request->get('column', 'id');
        $direction = $request->get('direction', 'asc');

        $blogs = Blog::with('Photo')
            ->whereNull('deleted_at')
            ->paginate($per_page, ['*'], 'page', $page);

        if ($search) {
            $blogs = Blog::with('Photo')
                ->whereNull('deleted_at')
                ->where('title', 'like', '%'.$search.'%')
                ->orWhere('sub_title', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($column_name) {
            $blogs = Blog::with('Photo')
                ->whereNull('deleted_at')
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($search && $column_name && $direction) {
            $blogs = Blog::with('Photo')
                ->whereNull('deleted_at')
                ->where('title', 'like', '%'.$search.'%')
                ->orWhere('sub_title', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if (sizeof($blogs->items()) > 0) {
            return response()->json($blogs);
        } else {
            return response()->json(false);
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'min:2|required',
            'sub_title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'image' => 'image|max:2048|required',
            'is_published' => 'integer|required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ]);
        }

        $blog = new Blog($validator->validated());
        $blog->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Blog has been saved!'
        ], 201);
    }

    public function show($id) {
        $blog = Blog::with('Photo')->findOrFail($id);

        $blog['date'] = date('Y-m-d', strtotime($blog['date']));

        return response()->json($blog);
    }

    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'min:2|required',
            'sub_title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'image' => 'string|required',
            'is_published' => 'integer|required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 400);
        }

        $blog = Blog::with('Photo')->findOrFail($id);

        $blog->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Blog has been updated'
        ]);
    }

    public function destroy($id) {
        $blog = Blog::with('Photo')->findOrFail($id);

        $blog->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Blog has been removed'
        ]);
    }
}
