<?php

namespace App\Http\Requests;

use App\Feed;
use Illuminate\Foundation\Http\FormRequest;

class FeedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $feedID = $this->route('feed');
        if (isset($feedID)) {
            return !empty(Feed::find($feedID));
        }

        return true;
    }

    /**
     * Feed input validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required|max:5000',
            'category_id' => 'nullable|exists:categories,id',
            'link' => 'required|url',
            'comments' => 'nullable|max:255',
            'publish_date' => 'required|date_format:Y-m-d H:i:s',
        ];
    }

    /**
     * Modify feed validation message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'publish_date.date_format' => 'The publish date does not match the format.',
        ];
    }
}
