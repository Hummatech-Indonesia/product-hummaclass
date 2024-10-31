<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\UserRewardInterface;
use App\Helpers\ResponseHelper;
use App\Http\Resources\UserRewardResource;
use App\Models\UserReward;
use App\Traits\PaginationTrait;
use Illuminate\Http\Request;

class UserRewardController extends Controller
{
    use PaginationTrait;
    private UserRewardInterface $userReward;

    public function __construct(UserRewardInterface $userReward)
    {
        $this->userReward = $userReward;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userRewards = $this->userReward->customPaginate($request);
        $data['paginate'] = $this->customPaginate($userRewards->currentPage(), $userRewards->lastPage());
        $data['data'] = UserRewardResource::collection($userRewards);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }
}
