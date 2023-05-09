<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SkillResource;
use App\Models\Skill;
use App\Models\Traits\ApiResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SkillController extends Controller
{
    use ApiResponseMessage;

    public function index()
    {
        // $user = Skill::all();
        // return $this->successResponse($user);

        return SkillResource::collection(Skill::all());
    }

    public function store(Request $request)
    {
        $validator = $this->validateUser();
        if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
        }

        $skill = Skill::create([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),

        ]);

        return $this->successResponse($skill,'Skill Created', 201);
    }

    public function update(Request $request, Skill $skill)
    {
        $validator = $this->validateUser();
        if($validator->fails()){
            return $this->errorResponse($validator->messages(), 422);
        }

        $skill = Skill::findOrFail($skill);
        $skill->name = $request->get('name');
        $skill->slug = $request->get('slug');
        $skill->save();

        return $this->successResponse($skill,'Skill Updated', 200);
    }

    public function show(Skill $skill)
    {
        // return $this->successResponse(new SkillResource($skill));
        return new SkillResource($skill);
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return $this->successResponse(null, 'Skill Deleted');
    }

    public function validateUser(){
        return Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:skills',

        ]);
    }
}
