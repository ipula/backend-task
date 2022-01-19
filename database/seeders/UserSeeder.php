<?php

namespace Database\Seeders;

use App\Models\UserAccounts;
use App\Models\UserRepositories;
use App\Service\GithubUserService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    private $githubUserService;
    public function __construct(GithubUserService $githubUserService)
    {
        $this->githubUserService = $githubUserService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $since = 1;
        $userData = $this->githubUserService->getAllUsersSeeder(['per_page'=>150,'since'=>$since]);
        foreach ($userData as $key => $data){
            $user = $this->githubUserService->getAUserSeeder([],$data['login']);
            $userRepo = $this->githubUserService->getUserReposSeeder([],$data['login']);

            $account = new UserAccounts();
            $account->name = $user['name'];
            $account->email = $user['email'];
            $account->avatar_url = $user['avatar_url'];
            $account->location = $user['location'];
            $account->login_name = $user['login'];
            $account->join_date = Carbon::parse($user['created_at'])->format('Y-m-d');
            $account->followers = $user['followers'];
            $account->followings = $user['following'];
            $account->public_repos = $user['public_repos'];
            $account->repo_count = count($userRepo);
            $account->public_gists = $user['public_gists'];
            if($account->save()){
                foreach ($userRepo as $index => $repository){
                    $repos = new UserRepositories();
                    $repos->user_account_id = $account->id;
                    $repos->name = $repository['name'];
                    $repos->forks = $repository['forks_count'];
                    $repos->stars = $repository['watchers'];
                    $repos->save();
                }
            }
        }
    }
}
