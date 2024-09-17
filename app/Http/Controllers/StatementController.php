<?php

namespace App\Http\Controllers;

use App\Http\Requests\Statement\StoreStatementRequest;
use App\Http\Requests\Statement\UpdateStatementRequest;
use App\Models\Statement;
use App\Models\File;
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

        if ($request->has('file')) {
            $path = $request->file('file')->store('statements');
            $file = new File(['path' => $path]);
            $statement->files()->save($file);
        }      

        $files = $statement->files();
        
        return response()->json($files);
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
