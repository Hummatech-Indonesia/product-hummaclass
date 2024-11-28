<?php

namespace App\Contracts\Repositories\Course;

use admin;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use App\Contracts\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Interfaces\Course\CategoryInterface;

class CourseRepository extends BaseRepository implements CourseInterface
{

    /**
     * Method __construct
     *
     * @param Course $course [explicite description]
     *
     * @return void
     */
    public function __construct(Course $course)
    {
        $this->model = $course;
    }
    /**
     * Method customPaginate
     *
     * @param Request $request [explicite description]
     * @param int $pagination [explicite description]
     *
     * @return LengthAwarePaginator
     */
    public function customPaginate(Request $request, int $pagination = 9): LengthAwarePaginator
    {
        $authorizationHeader = $request->header('Authorization');
        if ($authorizationHeader && str_starts_with($authorizationHeader, 'Bearer ')) {
            $token = substr($authorizationHeader, 7); // Ekstrak token dari header
        } else {
            $token = null;
        }
        $user = $token ? PersonalAccessToken::findToken($token)?->tokenable : null;

        return $this->model->query()
            ->with(['modules', 'subCategory.category'])
            ->when($request->is_ready, function ($query) use ($request) {
                $query->where('is_ready', $request->is_ready);
            })
            ->withCount('userCourses')
            ->when($request->title, function ($query) use ($request) {
                return $query->where('title', 'LIKE', '%' . $request->title . '%');
            })
            ->when($request->categories, function ($query) use ($request) {
                $query->when(
                    collect($request->categories)->filter()->isNotEmpty(),
                    function ($query) use ($request) {
                        $query->whereIn('sub_category_id', $request->categories);
                    }
                );
            })
            ->when($request->status, function ($query) use ($request) {
                return $query->where('is_ready', $request->status);
            })
            ->when($request->minimum, function ($query) use ($request) {
                return $query->where(function ($q) use ($request) {
                    $q->where('promotional_price', '>=', intval($request->minimum))
                        ->orWhereNull('promotional_price')
                        ->where('price', '>=', intval($request->minimum));
                });
            })
            ->when($request->maximum, function ($query) use ($request) {
                return $query->where(function ($q) use ($request) {
                    $q->where('promotional_price', '<=', intval($request->maximum))
                        ->orWhereNull('promotional_price')
                        ->where('price', '<=', intval($request->maximum));
                });
            })
            ->when($user?->hasRole('guest') || !$user, function ($query) {
                $query->where('is_ready', 1);
            })
            ->orderByDesc('created_at')
            ->fastPaginate($pagination);
    }

    /**
     * Method getTop
     *
     * @return mixed
     */
    public function getTop(): mixed
    {
        return $this->model
            ->with('subCategory')
            ->withCount('userCourses')
            ->where('is_ready', true)
            ->orderBy('user_courses_count', 'desc') // Mengurutkan berdasarkan userCourses count
            ->limit(4)
            ->get();
    }

    public function topRatings(): mixed
    {
        return $this->model
            ->with('subCategory')
            ->withCount('courseReviews')
            ->where('is_ready', true)
            ->orderBy('course_reviews_count', 'desc') // Mengurutkan berdasarkan courseReviews count
            ->limit(4)
            ->get();
    }


    /**
     * search
     *
     * @param  mixed $request
     * @return mixed
     */
    public function search(Request $request): mixed
    {
        $authorizationHeader = $request->header('Authorization');
        if ($authorizationHeader && str_starts_with($authorizationHeader, 'Bearer ')) {
            $token = substr($authorizationHeader, 7); // Ekstrak token dari header
        } else {
            $token = null;
        }
        $user = $token ? PersonalAccessToken::findToken($token)?->tokenable : null;

        return $this->model->query()
            ->with('modules')
            ->when($request->is_ready, function ($query) use ($request) {
                $query->where('is_ready', $request->is_ready);
            })
            ->withCount('userCourses')
            ->when($request->title, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->title . '%');
            })
            ->when($request->order === "best seller", function ($query) {
                $query->orderBy('user_courses_count', 'desc');
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('is_ready', $request->status);
            })
            ->when($request->maximum, function ($query) use ($request) {
                $query->where('price', '<=', $request->maximum);
            })
            ->when($request->minimum, function ($query) use ($request) {
                $query->where('price', '>=', $request->minimum);
            })
            // Tambahkan filter untuk guest
            ->when($user?->hasRole('guest') || !$user || $request->order === "best seller", function ($query) {
                $query->where('is_ready', 1);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }


    public function count(): mixed
    {
        return $this->model->query()->count();
    }

    /**
     * Method store
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }
    /**
     * Method show
     *
     * @param mixed $id [explicite description]
     *
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }
    /**
     * Method showWithSlug
     *
     * @param string $slug [explicite description]
     *
     * @return mixed
     */
    public function showWithSlug(Request $request, string $slug): mixed
    {
        return $this->model->query()->where(['slug' => $slug])
            ->when($request->transaction, function ($query) use ($request) {
                $query->with('transactions');
            })->firstOrFail();
    }

    /**
     * showWithSlugWithoutRequest
     *
     * @param  mixed $slug
     * @return mixed
     */
    public function showWithSlugWithoutRequest(string $slug): mixed
    {
        return $this->model->query()->where(['slug' => $slug])->firstOrFail();
    }
    /**
     * Method update
     *
     * @param mixed $id [explicite description]
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->show($id)->update($data);
    }
    /**
     * Method delete
     *
     * @param mixed $id [explicite description]
     *
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->show($id)->delete();
    }

    /**
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->whereHas('userCourses', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->fastPaginate(9);
    }
}
