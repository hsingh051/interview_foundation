<?php

namespace App\Repositories\User;


use App\Repositories\BaseRepository;
use App\User;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{

    /**
     * Associated Repository Model.
     */
    const MODEL = User::class;

    /**
     * @param  string|null  $token
     * @return bool
     */
    public function updateGithubToken(string $token = null): bool
    {
        $updateData = [
            'github_token' => $token ? Crypt::encryptString($token) : null
        ];

        if (User::where('id', Auth::user()->id)->update($updateData)) {
            return true;
        }

        return false;
    }

    /**
     * @param  User  $user
     * @return mixed
     */
    public function getUserRepositories(User $user)
    {
        return Github::getFactory()->make([
            'token' => Crypt::decryptString($user->github_token),
            'method' => 'token'
        ])->me()->repositories();
    }

}
