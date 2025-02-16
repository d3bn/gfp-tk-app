<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IssueController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->token = config('app.github_token');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $url = 'https://api.github.com/user/issues';
        $ch = curl_init($url);

        if ($request->has('state')) {
            curl_setopt($ch, CURLOPT_URL, $url. "?state={$request->state}");
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/vnd.github+json',
                "Authorization: Bearer {$this->token}",
                'X-GitHub-Api-Version: 2022-11-28',
                'User-Agent: GFP Takehome App',
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false || $httpCode !== 200) {
            abort($httpCode, curl_error($ch));
            curl_close($ch);
            return;
        }

        curl_close($ch);

        return view('issues', [
            'issues' => json_decode($response, true),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if (!$request->has('url')) {
            abort(400, 'Missing required parameters');
            return;
        }

        $url = urldecode($request->url);
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/vnd.github+json',
                "Authorization: Bearer {$this->token}",
                'X-GitHub-Api-Version: 2022-11-28',
                'User-Agent: GFP Takehome App',
            ]
        ]);

        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


        if ($data === false || $httpCode !== 200) {
            abort($httpCode, curl_error($ch));
            curl_close($ch);
            return;
        }

        curl_close($ch);

        return view('issue', [
            'issue' => json_decode($data, true),
        ]);
    }
}
