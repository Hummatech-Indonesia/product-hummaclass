<?php

namespace App\Traits\Datatables;

use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

trait InstituteDatatable
{

    /**
     * Datatable mockup for station resource
     *
     * @param mixed $collection
     *
     * @return JsonResponse
     * @throws Exception
     */

    /**
     * Datatable mockup for institute resource
     *
     * @param mixed $collection
     *
     * @return JsonResponse
     * @throws Exception
     */

    public function InstituteMockup(mixed $collection): JsonResponse
    {
        return DataTables::of($collection)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                return view('dashboard.pages.users.institutes.datatables.name', compact('data'));
            })
            ->editColumn('photo', function ($data) {
                return view('dashboard.pages.users.institutes.datatables.photo', compact('data'));
            })
            ->editColumn('email_verified_at', function ($data) {
                return view('dashboard.pages.users.institutes.datatables.email_verified_at', compact('data'));
            })
            ->editColumn('user_id', function ($data) {
                return view('dashboard.pages.users.institutes.datatables.user_id', compact('data'));
            })
            ->editColumn('status', function ($data) {
                return view('dashboard.pages.users.institutes.datatables.status', compact('data'));
            })
            ->editColumn('action', function ($data) {
                return view('dashboard.pages.users.institutes.datatables.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}