<?php

class CandidateTest extends TestCase
{
	/**
     * /candidates [GET]
     */
	public function testShouldReturnAllCandidates()
	{
		$this->get("api/v1/candidates", ['HTTP_Authorization' => 'bearer R1ZsSVVTa0R3azlKOEdxRWVSWU5wRExNamVEaDBkc21LNzRoZGRjbg==']);
		$this->seeStatusCode(200);
		$this->seeJsonStructure([
			'current_page',
			'data' => ['*' => 
				[
					'id',
					'first_name', 
					'last_name', 
					'email', 
					'contact_number',
					'gender', 
					'specialization', 
					'work_ex_year', 
					'candidate_dob', 
					'address', 
					'resume',
				]
			],
			"first_page_url",
			"from",
			"last_page",
			"last_page_url",
			"next_page_url",
			"path",
			"per_page",
			"prev_page_url",
			"to",
			"total"
		]);
	}

	/**
     * /api/v1/candidates/id [GET]
     */
    public function testShouldReturnCandidate(){
        $this->get("api/v1/candidates/2", ['HTTP_Authorization' => 'bearer R1ZsSVVTa0R3azlKOEdxRWVSWU5wRExNamVEaDBkc21LNzRoZGRjbg==']);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
        	[
	        	'id',
	        	'first_name', 
	        	'last_name', 
	        	'email', 
	        	'contact_number',
	        	'gender', 
	        	'specialization', 
	        	'work_ex_year', 
	        	'candidate_dob', 
	        	'address', 
	        	'resume',
	        	'created_at',
	        	'updated_at'
        	]
        );
        
    }

    /**
     * /api/v1/candidates [POST]
     */
    public function testShouldCreateCandidate(){

        $parameters = [
            'first_name' => 'Sam',
            'email' => 'sam1@example.com',
        ];

        $this->post("api/v1/candidates", $parameters, ['HTTP_Authorization' => 'bearer R1ZsSVVTa0R3azlKOEdxRWVSWU5wRExNamVEaDBkc21LNzRoZGRjbg==']);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
                [
                    'status',
                    'message',
                ]
        );
        
    }

    /**
     * /api/v1/candidates/search [POST]
     */
	public function testShouldReturnSearchedCandidates()
	{
		$parameters = [
            'first_name' => 'Sam',
            'email' => 'sam@example.com',
        ];

		$this->post("api/v1/candidates/search", $parameters, ['HTTP_Authorization' => 'bearer R1ZsSVVTa0R3azlKOEdxRWVSWU5wRExNamVEaDBkc21LNzRoZGRjbg==']);
		$this->seeStatusCode(200);
		$this->seeJsonStructure([
			'current_page',
			'data' => ['*' => 
				[
					'id',
					'first_name', 
					'last_name', 
					'email', 
					'contact_number',
					'gender', 
					'specialization', 
					'work_ex_year', 
					'candidate_dob', 
					'address', 
					'resume',
				]
			],
			"first_page_url",
			"from",
			"last_page",
			"last_page_url",
			"next_page_url",
			"path",
			"per_page",
			"prev_page_url",
			"to",
			"total"
		]);
	}

	
}