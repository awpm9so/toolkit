<?php

namespace App\Http\Controllers;

use App\Http\Requests\Statement\StoreStatementRequest;
use App\Http\Requests\Statement\UpdateStatementRequest;
use App\Models\Statement;
use App\Models\StatementFile;
use Illuminate\Support\Facades\Auth;

class StatementController extends Controller
{

    public function get(Statement $statement)
    {
        if (Auth::user()->cannot('get', $statement)) {
            return response(['message' => __('validation.custom.not_enough_rights')], 403);
        }

        return response()->json($statement);
    }

    public function store(StoreStatementRequest $request)
    {
        $validated = $request->validated();

        $statement = Statement::create([
            'user_id' => Auth::user()->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return response()->json($statement);
    }


    public function update(UpdateStatementRequest $request, Statement $statement)
    {
        if (Auth::user()->cannot('update', $statement)) {
            return response(['message' => __('validation.custom.not_enough_rights')], 403);
        }

        $validated = $request->validated();

        $statement->update($validated);

        // if (($validated('files')))
        // {
            $path = $request->file('files')->store('statements');
            StatementFile::create([
                'statement_id' => $statement->id,
                'path' => $path,
            ]);
        // }

        return response()->json($statement);
    }

    public function remove(Statement $statement)
    {
        if (Auth::user()->cannot('remove', $statement)) {
            return response(['message' => __('validation.custom.not_enough_rights')], 403);
        }

        $statement->delete();

        return response()->json(['message' => 'The statement was deleted successfully']);
    }
}
