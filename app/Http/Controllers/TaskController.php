<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Note;
use Illuminate\Http\Request;
use Validator;

class TaskController extends Controller
{
    /**
     * Retrive the tasks with its notes
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listTasks(Request $request)
    {
        try {
            $tasks = Task::query();

            if($request->has('filter')) {
                $filter = $request->get('filter');
                if(isset($filter['status']) && !empty($filter['status'])) {
                    $tasks->where('status', $filter['status']);
                }
                if(isset($filter['due_date']) && !empty($filter['due_date'])) {
                    $tasks->where('due_date', $filter['due_date']);
                }
                if(isset($filter['priority']) && !empty($filter['priority'])) {
                    $tasks->where('priority', $filter['priority']);
                }

                if(isset($filter['notes']) && !empty($filter['notes'])) {
                    $tasks->has('notes')->with('notes')->withCount('notes')->orderBy('notes_count', 'desc');
                } else {
                    $tasks->with('notes');
                }
            } else {
                $tasks->with('notes');
            }

            return response()->json([
                'success' => true,
                'data' => $tasks->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    /**
     * Create a task with its notes
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createTask(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'subject' => 'required', 
                'description' => 'required',
                'start_date' => 'required|date_format:Y-m-d',
                'due_date' => 'required|date_format:Y-m-d',
                'status' => 'required|in:New,Incomplete,Complete',
                'priority' => 'required|in:High,Medium,Low',
            ]);
    
            if ($validator->fails()) {    
                return response()->json([
                    'error' => true,
                    'message' => $validator->messages()
                ], 400);
            }
    
            $task = Task::create([
                'subject' => $request->subject,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'priority' => $request->priority
            ]);
    
            if($task) {
                foreach($request->notes as $key => $note) {
                    $file = $request->file('notes.'.$key.'.attachments');   

                    $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . \Carbon\Carbon::now()->format('h_i');
                    $file_extension = $file->getClientOriginalExtension();

                    $file_name_full = $file_name . '.' . $file_extension;
                
                    //Move Uploaded File
                    $destinationPath = 'uploads';
                    $file->move($destinationPath, $file_name_full);

                    Note::create([
                        'task_id' => $task->id,
                        'subject' => $note['subject'],
                        'attachment' => $file_name_full,
                        'note' => $note['note']
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Operation successful!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
