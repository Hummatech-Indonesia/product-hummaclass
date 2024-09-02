<?php

namespace App\Traits\Datatables;

use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

trait BlogCategoryDatatable
{

    public function BlogCategoryMockup(mixed $collection): JsonResponse
    {
        return DataTables::of($collection)
            ->addIndexColumn()
            ->editColumn('blogs', function ($data) {
                return view('dashboard.pages.blogs.blog-categories.datatables.blogs', compact('data'));
            })
            ->editColumn('action', function ($data) {
                return view('dashboard.pages.blogs.blog-categories.datatables.action', compact('data'));
            })
            ->rawColumns(['action', 'action'])
            ->toJson();
    }
}
