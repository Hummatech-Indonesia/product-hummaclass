<?php

namespace App\Traits\Datatables;

use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

trait FaceDatatable
{

    public function FaceMockup(mixed $collection): JsonResponse
    {
        return DataTables::of($collection)
            ->addIndexColumn()
            ->editColumn('photo', function ($data) {
                return view('dashboard.pages.users.faces.datatables.photo', compact('data'));
            })
            ->editColumn('action', function ($data) {
                return view('dashboard.pages.users.faces.datatables.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
