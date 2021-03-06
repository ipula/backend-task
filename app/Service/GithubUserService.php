<?php

namespace App\Service;

use App\Helpers\GuzzleWrapper;
use App\Models\UserAccounts;
use App\Models\UserRepositories;
use Illuminate\Support\Facades\Config;

class GithubUserService
{
    private $url;
    private $headers;
    public function __construct()
    {
        $this->url = 'https://api.github.com';
        $this->headers = [
            'Content-Type' =>'application/json',
            'Authorization'=>'token '.Config::get('custom_config.GITHUB_TOKEN')
        ];
    }

   public function getAllUsersSeeder($parameters =[]){
       $url =  $this->url.'/users';
       return GuzzleWrapper::get($url,'', $parameters, $this->headers);
    }

    public function getAUserSeeder($parameters =[],$name)
    {
        $url =  $this->url.'/users/'.$name;
        return GuzzleWrapper::get($url,'', $parameters, $this->headers);
    }

    public function getUserReposSeeder($parameters =[],$name)
    {
        $url =  $this->url.'/users/'.$name.'/repos';
        return GuzzleWrapper::get($url,'', $parameters, $this->headers);
    }

    public function getAllUsers($filters){

        $accounts = UserAccounts::with(['userRepositories']);
        if(isset($filters)){
            $accounts = $accounts->where('name','like', '%' . $filters . '%');
        }
        $accounts = $accounts
            ->orderBy('public_repos','DESC')
            ->orderBy('detail_requested','DESC')
            ->orderBy('followers','DESC')
            ->paginate(3);

        \Log::info("==== all user search result ", ['search'=>$filters,'data'=>json_encode($accounts)]);
        return $accounts;
    }

    public function getPopularUsers(){

        $accounts = UserAccounts::with(['userRepositories']);
        $accounts = $accounts
            ->orderBy('detail_requested','DESC')
            ->take(3)
            ->get();
        return $accounts;
    }

    public function getAUser($id)
    {
        $account = UserAccounts::with(['userRepositories'])
            ->find($id);
        $account->detail_requested = $account->detail_requested+1;
        $account->save();
        return $account;
    }

    public function getUserRepos($user_id,$filters)
    {
        $repos = UserRepositories::where('user_account_id',$user_id);
        if (isset($filters)){
            $repos = $repos->where('name','like', '%' . $filters . '%');
        }
        $repos = $repos->paginate(30);

        \Log::info("==== all user repos result ", ['search'=>$filters,'user_id'=>$user_id,'data'=>json_encode($repos)]);
        return $repos;
    }
}
