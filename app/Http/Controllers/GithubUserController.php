<?php

namespace App\Http\Controllers;


use App\Helpers\GuzzleWrapper;
use App\Service\GithubUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class GithubUserController extends Controller
{
    private $githubUserService;
    public function __construct(GithubUserService $githubUserService)
    {
        $this->githubUserService = $githubUserService;
    }

    function getAllUsers(Request $request){

        try {
            $filters = $request->get('search');
            $userData = $this->githubUserService->getAllUsers($filters);
            return response ()->json ( ['data' => $userData], 200 );
        } catch (\Exception $e) {
            throw new \App\Helpers\BackendException(
                'Unable get data from service endpoint:'. $e->getMessage()
            );
        }

    }

    function getAUser(){
        $usersData = $this->githubUserService->getAUser([],'wycats');
        return response ()->json ( ['data' => $usersData], 200 );
    }

    function getRepos($user_id,Request $request){
        try {
            $filters = $request->get('search');
            $userData = $this->githubUserService->getUserRepos($user_id,$filters);
            return response ()->json ( ['data' => $userData], 200 );
        } catch (\Exception $e) {
            throw new \App\Helpers\BackendException(
                'Unable get data from service endpoint:'. $e->getMessage()
            );
        }
    }

    function getUserDetails($id){
        try {
            $user_id = $id;
            $userData = $this->githubUserService->getAUser($user_id);
            return response ()->json ( ['data' => $userData], 200 );
        } catch (\Exception $e) {
            throw new \App\Helpers\BackendException(
                'Unable get data from service endpoint:'. $e->getMessage()
            );
        }
    }
}
