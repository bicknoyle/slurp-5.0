<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

use Auth;

class SearchRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		$search = $this->route('searches');
		if($search) {
			return $search->user_id == Auth::user()->id;
		}

		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		if($this->isMethod('patch') or $this->isMethod('post') or $this->isMethod('put')) {
			return [
				'title' => 'required|min:5',
				'terms' => 'required'
			];
		}
		else {
			return [];
		}

	}

}
