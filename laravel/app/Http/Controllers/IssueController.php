<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\MySqlHelper;
use App\Http\Requests\SearchIssue;
use App\Http\Requests\StoreIssue;
use App\Http\Requests\UpdateIssue;
use App\Models\Issue;
use Domain\Issue\IssueStatus;
use Domain\Issue\List\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = new Settings();
        $issues = DB::table('issues')->select(...$settings->getListFields())->simplePaginate($settings->getCountParPage());
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

    public function search(SearchIssue $request)
    {
        $query = DB::table('issues');
        foreach ($request->getKeywords() as $k) {
            $query->where('summary', 'like', sprintf('%%%s%%', MySqlHelper::escapeLikeParameter($k)));
        }
        $settings = new Settings();
        $query->select(...$settings->getListFields());
        return view('issue.index', ['issues' => $query->simplePaginate($settings->getCountParPage())]);
    }

    public function downloadCsv(Request $request)
    {
        return response()->streamDownload(function () {
            $file = new \SplFileObject('php://output', 'w');

            $file->fputcsv([
                'ID',
                '件名',
                '説明',
                '期限',
                '状態',
            ]);
            $issues = Issue::orderBy('id', 'desc');

            foreach ($issues->cursor() as $issue) {
                $file->fputcsv([
                    $issue->id,
                    $issue->summary,
                    $issue->description,
                    $issue->deadline,
                    $issue->status,
                ]);
            }
        }, 'issues.csv', [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment;',
        ]);
    }
}
