<?php

namespace App\Http\Controllers;

use App\FundingOpportunity;
use Illuminate\Http\Request;

class FundingOpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $FundingOpportunities = FundingOpportunity::orderBy('id', 'desc')->paginate(10);
        return view('FundingOpportunities.listOpportunity', compact('FundingOpportunities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('FundingOpportunities.createOpportunity');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

       /* $this->validate($request, [
            'fundingType' => 'required|max:255'
        ]);*/

        $fundingOpp = new FundingOpportunity();
        $fundingOpp = $this->request_to_DB_fields($fundingOpp, $request);
        $fundingOpp->save();
        $request->session()->flash('status', 'Successfully created Funding Opportunity: ' .$fundingOpp->name);
        return redirect(route('FundingOpportunities.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $f = FundingOpportunity::findorFail($id);
        return $f;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $funding_opp = FundingOpportunity::findOrFail($id);
        return view('FundingOpportunities.createOpportunity')->with('fundingOpp', $funding_opp);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fundingOpp = FundingOpportunity::findorFail($id);
        $fundingOpp = $this->request_to_DB_fields($fundingOpp, $request);
        $fundingOpp->save();


        $request->session()->flash('status', 'Successfully edited Funding Opportunity: ' .$fundingOpp->name);
        return redirect(route('FundingOpportunities.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FundingOpportunity $id)
    {
        $fundingOpp = FundingOpportunity::findorFail($id);
        $name = $fundingOpp->name;
        $fundingOpp->delete();
        Request::session()->flash('status', 'Successfully deleted Funding Opportunity: ' .$name);
    }

    private function request_to_DB_fields($fundingOpp, $request){
        $fundingOpp->name = $request->input('name');
        $fundingOpp->timestamps;
        $fundingOpp->announced = $request->input('announced');
        $fundingOpp->sponsor_deadline = $request->input('sponsor_deadline');
        $fundingOpp->internal_deadline = $request->input('internal_deadline');
        $fundingOpp->link_internal = $request->input('link_internal');
        $fundingOpp->link_external = $request->input('link_external');
        $fundingOpp->visible = $request->input('visible');
        $fundingOpp->limited_submission = $request->input('limited_submission');
        $fundingOpp->status = $request->input('status');
        $fundingOpp->user = -1;
        $fundingOpp->funding_type = $request->input('funding_type');
        $fundingOpp->timestamps;
        return $fundingOpp;
    }
}
