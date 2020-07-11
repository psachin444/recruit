<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use Carbon;

use Auth;

use App\User;

use App\Candidate;

class CandidateController extends Controller
{


    /**
     * Returns list of candidates.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
      $limit = 25;

      if($request->limit) {
        $limit = $request->limit;
      }

      $candidates = Candidate::with('user')->latest()->paginate($limit);

      return $candidates;
    }

    /**
     * Store a newly created candidate in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
      $this->validate($request, [
        'first_name' => 'required|string',
        'last_name' => 'string',
        'email' => 'email|unique:candidates',
        'contact_number' => 'numeric|size:10',
        'specialization' => 'string|max:200',
        'work_ex_year' => 'integer|min:0|max:30',
        'candidate_dob' => 'date',
        'address' => 'string|max:500',
        ]);

      $candidate = Candidate::create($request->except('resume', 'candidate_dob', 'user_id'));
      $candidate->user_id = Auth::id();
      $candidate->candidate_dob = \Carbon\Carbon::parse($request->candidate_dob)->timestamp;
      $candidate->save();
      if ($request->hasFile('resume')) {
        $original_filename = $request->file('resume')->getClientOriginalName();
        $original_filename_arr = explode('.', $original_filename);
        $file_ext = end($original_filename_arr);
        
        // Check if selected file is pdf
        if($file_ext != 'pdf') {
          return response()->json([
            'status' => 422,
            'error' => 'Please select pdf only',
            ]);
        }
        $destination_path = './uploads/resume/';
        $file_name = 'Resume-'.$request->first_name . time() . '.' . $file_ext;

        if ($request->file('resume')->move($destination_path, $file_name)) {
          $candidate->resume = '/uploads/resume/' . $file_name;
          $candidate->save();
        } else {
          return response('Cannot upload file');
        }
      }

      return response([
        'status' => 200,
        'message' => 'Candidate added',
        ]);
    }

    /**
     * Display the specified candidate.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getCandidate($id)
    {
      // $candidate = Candidate::find($id);
      if(!$candidate = Candidate::with('user')->find($id)) {
        return response()->json(['No Record Found.',404]);
      } 
        return $candidate;
    }

    /**
     * Display the specified candidate.
     *
     * @param  string  $first_name
     * @param  string  $last_name
     * @param  email  $email
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

      $this->validate($request,[
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'email'
        ]);

      $limit = 25;

      if($request->limit) {
        $limit = $request->limit;
      }

      $constraints = array_only($request->all(), 'first_name', 'last_name', 'email');

      $candidates = Candidate::where($constraints)->paginate($limit);

      return $candidates;
    }
  }
