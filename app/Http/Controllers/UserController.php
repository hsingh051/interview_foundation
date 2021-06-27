<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->users = new UserRepository();
    }

    /**
     * @param  Request  $request
     */
    public function updateGithubToken(Request $request)
    {
        if($this->users->updateGithubToken($request->githubToken)){
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => true]);
    }

    /**
     * @param  Request  $request
     */
    public function getRepositories(Request $request)
    {

        $repositories = $this->users->getUserRepositories(Auth::user());

        return response()->json(['data' => [
            'repositories' => $repositories
        ]]);
    }
}
