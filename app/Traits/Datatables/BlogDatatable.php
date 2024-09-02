<?php

namespace App\Traits\Datatables;

use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

trait BlogDatatable
{

    public function BlogMockup(mixed $collection): JsonResponse
    {
        return DataTables::of($collection)
            ->addIndexColumn()
            ->editColumn('image', function ($data) {
                return view('dashboard.pages.blogs.datatables.image', compact('data'));
            })
            ->editColumn('created_at', function ($data) {
                return view('dashboard.pages.blogs.datatables.created_at', compact('data'));
            })
            ->editColumn('action', function ($data) {
                return view('dashboard.pages.blogs.datatables.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
