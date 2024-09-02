<?php

namespace App\Traits\Datatables;

use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

trait UserDatatable
{

    public function UserMockup(mixed $collection): JsonResponse
    {
        return DataTables::of($collection)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                return view('dashboard.pages.users.datatables.name', compact('data'));
            })
            ->editColumn('photo', function ($data) {
                return view('dashboard.pages.users.datatables.photo', compact('data'));
            })
            ->editColumn('email_verified_at', function ($data) {
                return view('dashboard.pages.users.datatables.email_verified_at', compact('data'));
            })
            ->editColumn('user_id', function ($data) {
                return view('dashboard.pages.users.datatables.user_id', compact('data'));
            })
            ->editColumn('status', function ($data) {
                return view('dashboard.pages.users.datatables.status', compact('data'));
            })
            ->editColumn('action', function ($data) {
                return view('dashboard.pages.users.datatables.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
