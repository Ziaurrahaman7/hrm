<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::withCount('employees')->get();
        return view('skills.index', compact('skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills,name'
        ]);

        Skill::create($request->only('name'));
        return redirect()->route('skills.index')->with('success', 'Skill created successfully.');
    }
    
    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills,name,' . $skill->id
        ]);

        $skill->update($request->only('name'));
        return redirect()->route('skills.index')->with('success', 'Skill updated successfully.');
    }
    
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('skills.index')->with('success', 'Skill deleted successfully.');
    }
}
