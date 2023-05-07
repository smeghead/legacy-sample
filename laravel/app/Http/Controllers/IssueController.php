<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreIssue;
use App\Http\Requests\UpdateIssue;
use App\Models\Issue;
use Domain\Issue\IssueStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $issues = DB::table('issues')->select('id', 'summary', 'deadline', 'description', 'status')->simplePaginate(3);
        return view('issue.index', ['issues' => $issues]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('issue.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIssue $request)
    {
        $issue = new Issue();
        $status = IssueStatus::create();

        $issue->summary = $request->input('summary');
        $issue->description = $request->input('description');
        $issue->deadline = $request->input('deadline');
        $issue->status = $status->value();
        $issue->save();

        return redirect('issue');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $issue = Issue::find($id);
        return view('issue/show', ['issue' => $issue]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $issue = Issue::find($id);
        $status = IssueStatus::createFromValue($issue->status);
        return view('issue/edit', ['issue' => $issue, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIssue $request, string $id)
    {
        $issue = Issue::find($id);
        $issue->summary = $request->input('summary');
        $issue->description = $request->input('description');
        $issue->deadline = $request->input('deadline');
        $issue->status = $request->input('status');
        $issue->save();

        return redirect('issue');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $issue = Issue::find($id);
        $issue->delete();
        return redirect('issue');
    }

    public function search(Request $request)
    {
        $q = $request->input('q') ?? '';
        $q = mb_convert_kana($q, 's');
        $keywords = preg_split('/\s+/', $q);
        $query = DB::table('issues');
        foreach ($keywords as $k) {
            $query->where('summary', 'like', sprintf('%%%s%%', str_replace(['%', '_'], ['\%', '\_'], $k)));
        }
        $query->select('id', 'summary', 'deadline', 'description', 'status');
        return view('issue.index', ['issues' => $query->simplePaginate(3)]);
    }
}
