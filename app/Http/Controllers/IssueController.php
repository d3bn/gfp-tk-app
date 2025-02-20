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

        $issues = json_decode($response, true);

        $filteredIssues = array_filter($issues, function ($issue) {
            $isWontfix = false;

            foreach ($issue['labels'] as $label) {
                if ($label['name'] === 'wontfix') {
                    $isWontfix = true;
                }
            }

            return $isWontfix === false;
        });

        return view('issues', [
            'issues' => $filteredIssues,
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

    public function edit(Request $request)
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

        $issue = json_decode($data, true);

        $repoUrl = explode('/', $issue['repository_url']);
        $repoName = end($repoUrl);

        $issue['repo_name'] = $repoName;

        return view('edit', [
            'issue' => $issue,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'body' => 'required',
            'owner' => 'required',
            'repo' => 'required',
            'issue_number' => 'required',
        ]);

        $ch = curl_init("https://api.github.com/repos/{$data['owner']}/{$data['repo']}/issues/{$data['issue_number']}");

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/vnd.github+json',
                "Authorization: Bearer {$this->token}",
                'X-GitHub-Api-Version: 2022-11-28',
                'User-Agent: GFP Takehome App',
            ],
            CURLOPT_POSTFIELDS => json_encode(['body' => $data['body']]),
            CURLOPT_CUSTOMREQUEST => 'PATCH',
        ]);

        curl_exec($ch);
        curl_close($ch);

        return redirect('/');
    }
}
