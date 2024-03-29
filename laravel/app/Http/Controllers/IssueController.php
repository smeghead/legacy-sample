<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\MySqlHelper;
use App\Http\Requests\SearchIssue;
use App\Http\Requests\StoreIssue;
use App\Http\Requests\UpdateIssue;
use App\Models\Issue;
use Domain\Issue\IssueStatus;
use Domain\Issue\List\CsvFormat;
use Domain\Issue\List\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $settings = new Settings();
        $issues = DB::table('issues')->select(...$settings->getListFields())->simplePaginate($settings->getCountParPage());
        return view('issue.index', ['issues' => $issues]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('issue.create');
    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(string $id)
    {
        $issue = Issue::find($id);
        return view('issue/show', ['issue' => $issue]);
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $id)
    {
        $issue = Issue::find($id);
        $status = IssueStatus::createFromValue($issue->status);
        return view('issue/edit', ['issue' => $issue, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(string $id)
    {
        $issue = Issue::find($id);
        $issue->delete();
        return redirect('issue');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadCsv(Request $request)
    {
        $now = new \DateTimeImmutable('now');
        $csvFormat = new CsvFormat($now);

        return response()->streamDownload(function () use ($csvFormat) {
            $file = new \SplFileObject('php://output', 'w');

            $file->fputcsv($csvFormat->getHeaders());

            $issues = Issue::orderBy('id', 'desc');

            foreach ($issues->cursor() as $issue) {
                $file->fputcsv($csvFormat->convertRow($issue->toArray()));
            }
        }, $csvFormat->getDownloadFilename(), [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment;',
        ]);
    }
}
