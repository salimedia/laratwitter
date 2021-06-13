<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;


class TwitterController extends Controller
{
    public function index()
    {
        return "tett";
    }

    public function twitter_oauth()
    {
        $callback = 'http://twitter.pro/twitter/callback';
        $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'), env('TWITTER_CONSUMER_SECRET'));
        //env('TWITTER_ACCESS_TOKEN'), env('TWITTER_ACCESS_TOKEN_SECRET')
        $_access_token = $connection->oauth('oauth/request_token', ['oauth_callback' => $callback]);
        $_route = $connection->url('oauth/authorize', ['oauth_token' => $_access_token['oauth_token']]);
        return redirect($_route);
    }


    public function callback(Request $request)
    {
        $response = $request->all();
        $oauth_token    = $response['oauth_token'];
        $oauth_verifier = $response['oauth_verifier'];

        $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'), env('TWITTER_CONSUMER_SECRET'), $oauth_token, $oauth_verifier);

        $token = $connection->oauth('oauth/access_token', ['oauth_verifier' => $oauth_verifier]);

        $oauth_token    = $token['oauth_token'];
        $oauth_token_secret = $token['oauth_token_secret'];

        // Post Tweet goes here
        $this->postTwitterMessage($oauth_token, $oauth_token_secret);
    }

    public function postTwitterMessage($oauth_token, $oauth_token_secret)
    {
        $push = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'), env('TWITTER_CONSUMER_SECRET'), $oauth_token, $oauth_token_secret);
        $push->setTimeouts(10,15);
        $push->post('statuses/update', ['status' => 'Hello Salim From #Laravel']);

        return redirect()->route('index');
    }


}
